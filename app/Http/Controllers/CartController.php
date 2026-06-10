<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CoursePricing;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAttendee;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCourseAccess;
use App\Models\UserSubscription;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display Shopping Cart Items
     */
    public function index()
    {
        // Automatically merge or link any guest session cart to the logged in user
        $this->mergeSessionCart();

        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::with(['course.speaker', 'coursePricing', 'subscriptionPlan.courses', 'subscriptionPlan.industries'])
            ->where('cart_id', $cart->id)
            ->get();

        $total = 0.00;
        foreach ($cartItems as $item) {
            $total += (float)$item->total_price;
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add course with custom registration options to the shopping cart
     */
    public function add(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $arrayStr = $request->input('array'); // The serialized packages list e.g. `array('1 Attendee'=>'185.00','3 Attendees'=>'395.00')`
        
        $cart = $this->getOrCreateCart();

        CartItem::where('cart_id', $cart->id)
            ->where('item_type', 'subscription')
            ->delete();

        // Delete any existing cart items for this course in the active cart to start fresh
        CartItem::where('cart_id', $cart->id)
            ->where('course_id', $course->id)
            ->delete();

        $addedAny = false;

        if ($arrayStr) {
            // Find all chosen CoursePricing items by parsing the labels
            preg_match_all("/'([^']+)'=>/", $arrayStr, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $chosenLabel) {
                    $pricing = CoursePricing::where('course_id', $course->id)
                        ->where('label', $chosenLabel)
                        ->first();
                    if ($pricing) {
                        // Extract quantity from label (e.g., "6 Attendees" -> 6, "6 ODs & 6 Transcripts" -> 6)
                        $quantity = 1;
                        if (preg_match('/^(\d+)\s/', $chosenLabel, $matches)) {
                            $quantity = (int)$matches[1];
                        }
                        
                        CartItem::create([
                            'cart_id' => $cart->id,
                            'item_type' => 'course',
                            'course_id' => $course->id,
                            'pricing_id' => $pricing->id,
                            'quantity' => $quantity,
                            'unit_price' => (float)$pricing->price,
                            'total_price' => (float)$pricing->price * $quantity,
                        ]);
                        $addedAny = true;
                    }
                }
            }
        }

        if (!$addedAny) {
            // Fetch the default first pricing item from database if no options specified
            $pricing = CoursePricing::where('course_id', $course->id)
                ->orderBy('sort_order')
                ->first();
            if ($pricing) {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'item_type' => 'course',
                    'course_id' => $course->id,
                    'pricing_id' => $pricing->id,
                    'quantity' => 1,
                    'unit_price' => (float)$pricing->price,
                    'total_price' => (float)$pricing->price,
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Course added to your cart successfully!');
    }

    /**
     * Remove item from shopping cart
     */
    public function remove($id)
    {
        $cart = $this->getOrCreateCart();
        $deleted = CartItem::where('cart_id', $cart->id)
            ->where('id', $id)
            ->delete();

        if (!$deleted) {
            CartItem::where('cart_id', $cart->id)
                ->where('course_id', $id)
                ->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from your cart.');
    }

    public function showCheckout()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::with(['course', 'coursePricing', 'subscriptionPlan.courses', 'subscriptionPlan.industries'])
            ->where('cart_id', $cart->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is currently empty.');
        }

        if ($this->hasMixedCheckoutItems($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Please checkout subscription plans and courses separately.');
        }

        $subtotal = (float) $cartItems->sum('total_price');
        $coupon = $this->activeCouponForSubtotal($subtotal);
        $discount = $coupon ? $this->couponDiscount($coupon, $subtotal) : 0.00;
        $total = max($subtotal - $discount, 0);

        $gateways = PaymentGateway::with('settings')
            ->where('status', 1)
            ->whereIn('slug', ['stripe', 'paypal'])
            ->orderByDesc('is_default')
            ->orderBy('sort_order')
            ->get()
            ->unique('slug')
            ->values();

        return view('cart.checkout', compact('cartItems', 'subtotal', 'coupon', 'discount', 'total', 'gateways'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:80',
        ]);

        $cart = $this->getOrCreateCart();
        $subtotal = (float) CartItem::where('cart_id', $cart->id)->sum('total_price');

        if ($subtotal <= 0) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is currently empty.');
        }

        $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))->first();

        if (!$coupon) {
            return back()->withErrors(['coupon_code' => 'Invalid coupon code.']);
        }

        $error = $this->couponValidationError($coupon, $subtotal);
        if ($error) {
            return back()->withErrors(['coupon_code' => $error]);
        }

        session(['checkout_coupon_id' => $coupon->id]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('checkout_coupon_id');

        return back()->with('success', 'Coupon removed successfully!');
    }

    /**
     * Create account when needed, then send the order to the chosen gateway.
     */
    public function processCheckout(Request $request)
    {
        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is currently empty.');
        }

        $requiresAttendees = $cartItems->contains(function($item) {
            return $item->item_type !== 'subscription' && (int) ($item->quantity ?? 1) >= 2;
        });
        $attendeesRule = $requiresAttendees ? 'required|array' : 'nullable|array';

        if (Auth::check()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:50',
                'company_name' => 'nullable|string|max:255',
                'job_title' => 'nullable|string|max:255',
                'address_line_1' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:120',
                'state' => 'nullable|string|max:120',
                'country' => 'nullable|string|max:120',
                'postal_code' => 'nullable|string|max:40',
                'payment_gateway' => 'required|in:stripe,paypal',
                'attendees' => $attendeesRule,
                'attendees.*.name' => 'required|string|max:255',
                'attendees.*.email' => 'required|email|max:255',
                'attendees.*.phone' => 'nullable|string|max:50',
                'attendees.*.job_title' => 'nullable|string|max:255',
                'attendees.*.item_id' => 'required|integer',
            ]);

            $user = Auth::user();
            $user->update($request->only(['name', 'phone', 'company_name', 'job_title']));
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:50',
                'company_name' => 'nullable|string|max:255',
                'job_title' => 'nullable|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'address_line_1' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:120',
                'state' => 'nullable|string|max:120',
                'country' => 'nullable|string|max:120',
                'postal_code' => 'nullable|string|max:40',
                'payment_gateway' => 'required|in:stripe,paypal',
                'attendees' => $attendeesRule,
                'attendees.*.name' => 'required|string|max:255',
                'attendees.*.email' => 'required|email|max:255',
                'attendees.*.phone' => 'nullable|string|max:50',
                'attendees.*.job_title' => 'nullable|string|max:255',
                'attendees.*.item_id' => 'required|integer',
            ]);

            if (User::where('email', $request->email)->exists()) {
                return back()
                    ->withInput($request->except(['password', 'password_confirmation']))
                    ->withErrors(['email' => 'This email already has an account. Please login to continue checkout.']);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'job_title' => $request->job_title,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'status' => 'active',
            ]);

            Auth::login($user);
            $cart->update(['user_id' => $user->id, 'session_id' => null]);
        }

        if ($request->filled('address_line_1')) {
            UserAddress::updateOrCreate(
                ['user_id' => $user->id, 'type' => 'billing', 'is_default' => 1],
                [
                    'name' => $user->name,
                    'phone' => $request->phone,
                    'company_name' => $request->company_name,
                    'address_line_1' => $request->address_line_1,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'postal_code' => $request->postal_code,
                ]
            );
        }

        $gateway = $this->gatewayForCheckout($request->payment_gateway);
        if (!$gateway) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['payment_gateway' => 'Selected payment gateway is not available.']);
        }

        $order = $this->createPendingOrderForUser($user, $gateway, $request->input('attendees', []));

        if ((float) $order->grand_total <= 0) {
            $this->markOrderPaid($order, null, [
                'transaction_id' => 'FREE-' . $order->order_number,
                'gateway_payment_id' => 'coupon_discount',
                'raw_response' => ['message' => 'Order total was fully discounted.'],
            ]);

            return redirect()->route('home')->with('success', 'Congratulations! Your checkout is complete and your account/access is ready.');
        }

        try {
            return redirect()->away($this->paymentRedirectUrl($order, $gateway, $cartItems->contains('item_type', 'subscription')));
        } catch (\Throwable $e) {
            report($e);

            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
            ]);

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['payment_gateway' => 'Payment could not be started. ' . $e->getMessage()]);
        }
    }

    public function stripeSuccess(Request $request, Order $order)
    {
        $gateway = $this->gatewayForCheckout('stripe');
        $sessionId = $request->query('session_id');

        if (!$gateway || !$sessionId || !$this->orderBelongsToCurrentUser($order)) {
            return redirect()->route('cart.checkout')->with('error', 'Unable to verify Stripe payment.');
        }

        try {
            $response = Http::withToken($this->stripeSecretKey($gateway))
                ->get('https://api.stripe.com/v1/checkout/sessions/' . urlencode($sessionId));
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('cart.checkout')->with('error', 'Unable to verify Stripe payment.');
        }

        if (!$response->successful()) {
            return redirect()->route('cart.checkout')->with('error', 'Stripe payment verification failed.');
        }

        $session = $response->json();
        if (($session['payment_status'] ?? null) !== 'paid' || (string) data_get($session, 'metadata.order_id') !== (string) $order->id) {
            return redirect()->route('cart.checkout')->with('error', 'Stripe payment is not complete yet.');
        }

        $this->markOrderPaid($order, $gateway, [
            'transaction_id' => $session['id'] ?? $sessionId,
            'gateway_order_id' => $session['id'] ?? $sessionId,
            'gateway_payment_id' => $session['payment_intent'] ?? null,
            'payer_email' => data_get($session, 'customer_details.email'),
            'raw_response' => $session,
            'gateway_subscription_id' => $session['subscription'] ?? null,
            'auto_renew' => !empty($session['subscription']),
        ]);

        return redirect()->route('home')->with('success', 'Payment successful! Your account/access is ready.');
    }

    public function paypalSuccess(Request $request, Order $order)
    {
        $gateway = $this->gatewayForCheckout('paypal');
        $paypalOrderId = $request->query('token');
        $paypalSubscriptionId = $request->query('subscription_id');
        $isSubscriptionOrder = $order->items()->where('item_type', 'subscription')->exists();

        if (!$paypalSubscriptionId && $isSubscriptionOrder) {
            $paypalSubscriptionId = $order->transactions()
                ->where('gateway_slug', 'paypal')
                ->whereNotNull('gateway_order_id')
                ->latest()
                ->value('gateway_order_id');
        }

        if (!$gateway || (!$paypalOrderId && !$paypalSubscriptionId) || !$this->orderBelongsToCurrentUser($order)) {
            return redirect()->route('cart.checkout')->with('error', 'Unable to verify PayPal payment.');
        }

        if ($paypalSubscriptionId) {
            try {
                $accessToken = $this->paypalAccessToken($gateway);
                $response = Http::withToken($accessToken)
                    ->get($this->paypalBaseUrl($gateway) . '/v1/billing/subscriptions/' . urlencode($paypalSubscriptionId));
            } catch (\Throwable $e) {
                report($e);
                return redirect()->route('cart.checkout')->with('error', 'Unable to verify PayPal subscription.');
            }

            if (!$response->successful() || !in_array($response->json('status'), ['ACTIVE', 'APPROVAL_PENDING'], true)) {
                return redirect()->route('cart.checkout')->with('error', 'PayPal subscription is not active yet.');
            }

            $subscription = $response->json();
            $this->markOrderPaid($order, $gateway, [
                'transaction_id' => $paypalSubscriptionId,
                'gateway_order_id' => $paypalSubscriptionId,
                'gateway_payment_id' => $paypalSubscriptionId,
                'payer_email' => data_get($subscription, 'subscriber.email_address'),
                'raw_response' => $subscription,
                'gateway_subscription_id' => $paypalSubscriptionId,
                'auto_renew' => true,
            ]);

            return redirect()->route('home')->with('success', 'Subscription activated! Your account/access is ready.');
        }

        try {
            $accessToken = $this->paypalAccessToken($gateway);
            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->paypalBaseUrl($gateway) . '/v2/checkout/orders/' . urlencode($paypalOrderId) . '/capture');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('cart.checkout')->with('error', 'Unable to capture PayPal payment.');
        }

        if (!$response->successful()) {
            return redirect()->route('cart.checkout')->with('error', 'PayPal payment capture failed.');
        }

        $capture = $response->json();
        if (($capture['status'] ?? null) !== 'COMPLETED') {
            return redirect()->route('cart.checkout')->with('error', 'PayPal payment is not complete yet.');
        }

        $paypalCustomId = data_get($capture, 'purchase_units.0.payments.captures.0.custom_id')
            ?: data_get($capture, 'purchase_units.0.custom_id');
        if ($paypalCustomId && (string) $paypalCustomId !== (string) $order->id) {
            return redirect()->route('cart.checkout')->with('error', 'PayPal payment does not match this order.');
        }

        $captureId = data_get($capture, 'purchase_units.0.payments.captures.0.id');

        $this->markOrderPaid($order, $gateway, [
            'transaction_id' => $captureId ?: $paypalOrderId,
            'gateway_order_id' => $paypalOrderId,
            'gateway_payment_id' => $captureId,
            'payer_email' => data_get($capture, 'payer.email_address'),
            'raw_response' => $capture,
        ]);

        return redirect()->route('home')->with('success', 'Payment successful! Your account/access is ready.');
    }

    public function paymentCancel(Order $order)
    {
        if ($this->orderBelongsToCurrentUser($order) && $order->payment_status === 'pending') {
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed',
            ]);

            $order->transactions()->where('status', 'pending')->update(['status' => 'cancelled']);
        }

        return redirect()->route('cart.checkout')->with('error', 'Payment was cancelled. You can try again anytime.');
    }

    public function stripeWebhook(Request $request)
    {
        $gateway = $this->gatewayForCheckout('stripe');
        if (!$gateway || !$this->validStripeWebhookSignature($request, $gateway)) {
            return response()->json(['message' => 'Invalid signature.'], 400);
        }

        $payload = $request->json()->all();
        $event = $this->storeWebhookEvent('stripe', $payload['id'] ?? Str::uuid()->toString(), $payload['type'] ?? 'unknown', $payload);
        if (!$event->wasRecentlyCreated && $event->status === 'processed') {
            return response()->json(['received' => true]);
        }

        try {
            $type = $payload['type'] ?? '';
            $object = data_get($payload, 'data.object', []);
            $subscriptionId = $object['subscription'] ?? $object['id'] ?? null;

            if ($type === 'invoice.payment_succeeded' && $subscriptionId) {
                $this->extendSubscriptionFromWebhook($subscriptionId, $object, 'stripe');
            }

            if (in_array($type, ['invoice.payment_failed', 'customer.subscription.deleted'], true) && $subscriptionId) {
                $this->pauseSubscriptionFromWebhook($subscriptionId, $type === 'customer.subscription.deleted' ? 'cancelled' : 'paused');
            }

            $event->update(['status' => 'processed', 'processed_at' => now()]);
        } catch (\Throwable $e) {
            report($e);
            $event->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            return response()->json(['message' => 'Webhook failed.'], 500);
        }

        return response()->json(['received' => true]);
    }

    public function paypalWebhook(Request $request)
    {
        $payload = $request->json()->all();
        $eventType = $payload['event_type'] ?? 'unknown';
        $event = $this->storeWebhookEvent('paypal', $payload['id'] ?? Str::uuid()->toString(), $eventType, $payload);
        if (!$event->wasRecentlyCreated && $event->status === 'processed') {
            return response()->json(['received' => true]);
        }

        try {
            $resource = $payload['resource'] ?? [];
            $subscriptionId = data_get($resource, 'billing_agreement_id')
                ?: data_get($resource, 'billing_subscription_id')
                ?: data_get($resource, 'id');

            if (in_array($eventType, ['PAYMENT.SALE.COMPLETED', 'PAYMENT.CAPTURE.COMPLETED'], true) && $subscriptionId) {
                $this->extendSubscriptionFromWebhook($subscriptionId, $resource, 'paypal');
            }

            if (in_array($eventType, ['BILLING.SUBSCRIPTION.CANCELLED', 'BILLING.SUBSCRIPTION.SUSPENDED', 'BILLING.SUBSCRIPTION.EXPIRED'], true) && $subscriptionId) {
                $this->pauseSubscriptionFromWebhook($subscriptionId, $eventType === 'BILLING.SUBSCRIPTION.CANCELLED' ? 'cancelled' : 'paused');
            }

            $event->update(['status' => 'processed', 'processed_at' => now()]);
        } catch (\Throwable $e) {
            report($e);
            $event->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            return response()->json(['message' => 'Webhook failed.'], 500);
        }

        return response()->json(['received' => true]);
    }

    private function createPendingOrderForUser(User $user, PaymentGateway $gateway, $attendeesData = [])
    {
        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::with(['course', 'coursePricing', 'subscriptionPlan.courses', 'subscriptionPlan.industries'])
            ->where('cart_id', $cart->id)
            ->get();

        $subtotal = (float) $cartItems->sum('total_price');
        $coupon = $this->activeCouponForSubtotal($subtotal);
        $discount = $coupon ? $this->couponDiscount($coupon, $subtotal) : 0.00;
        $grandTotal = max($subtotal - $discount, 0);

        $addressSnapshot = [
            'name' => $user->name,
            'phone' => request()->input('phone'),
            'company_name' => request()->input('company_name'),
            'address_line_1' => request()->input('address_line_1'),
            'address_line_2' => request()->input('address_line_2'),
            'city' => request()->input('city'),
            'state' => request()->input('state'),
            'country' => request()->input('country'),
            'postal_code' => request()->input('postal_code'),
        ];

        $utmData = session('utm_data', [
            'utm_source' => null,
            'utm_medium' => null,
            'utm_campaign' => null,
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => $user->id,
            'coupon_id' => $coupon?->id,
            'subtotal' => $subtotal,
            'discount_total' => $discount,
            'tax_total' => 0.00,
            'grand_total' => $grandTotal,
            'currency' => strtoupper($gateway->getSetting('currency') ?: 'USD'),
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_gateway' => $gateway->slug,
            'notes' => json_encode([
                'address_snapshot' => $addressSnapshot,
                'utm_data' => $utmData,
            ]),
        ]);

        foreach ($cartItems as $item) {
            if ($item->item_type === 'subscription') {
                $plan = $item->subscriptionPlan;
                if (!$plan) {
                    continue;
                }

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => 'subscription',
                    'subscription_plan_id' => $plan->id,
                    'title' => $plan->name,
                    'description' => $plan->description,
                    'quantity' => 1,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);

                continue;
            }

            // Create Order Item record
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'item_type' => 'course',
                'course_id' => $item->course_id,
                'pricing_id' => $item->pricing_id,
                'title' => $item->course->title ?? 'Webinar Enrollment',
                'description' => $item->coursePricing ? $item->coursePricing->label : 'Standard Registration',
                'quantity' => 1,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
            ]);

            if ((int) ($item->quantity ?? 1) < 2) {
                continue;
            }

            // Save attendees from form data
            $itemAttendees = array_filter($attendeesData, function($attendee) use ($item) {
                return isset($attendee['item_id']) && (int)$attendee['item_id'] === $item->id;
            });

            foreach ($itemAttendees as $attendee) {
                OrderAttendee::create([
                    'order_item_id' => $orderItem->id,
                    'order_id' => $order->id,
                    'name' => $attendee['name'] ?? $user->name,
                    'email' => $attendee['email'] ?? $user->email,
                    'phone' => $attendee['phone'] ?? $user->phone,
                    'job_title' => $attendee['job_title'] ?? $user->job_title,
                ]);
            }

        }

        PaymentTransaction::create([
            'order_id' => $order->id,
            'gateway_id' => $gateway->id,
            'gateway_slug' => $gateway->slug,
            'amount' => $order->grand_total,
            'currency' => $order->currency,
            'status' => 'pending',
        ]);

        return $order;
    }

    private function paymentRedirectUrl(Order $order, PaymentGateway $gateway, bool $isSubscriptionCheckout = false)
    {
        if ($isSubscriptionCheckout) {
            return match ($gateway->slug) {
                'stripe' => $this->createStripeSubscriptionCheckoutUrl($order, $gateway),
                'paypal' => $this->createPaypalSubscriptionApprovalUrl($order, $gateway),
                default => throw new \InvalidArgumentException('Unsupported payment gateway.'),
            };
        }

        return match ($gateway->slug) {
            'stripe' => $this->createStripeCheckoutUrl($order, $gateway),
            'paypal' => $this->createPaypalApprovalUrl($order, $gateway),
            default => throw new \InvalidArgumentException('Unsupported payment gateway.'),
        };
    }

    private function createStripeSubscriptionCheckoutUrl(Order $order, PaymentGateway $gateway)
    {
        $secretKey = $this->stripeSecretKey($gateway);

        $order->loadMissing('items.subscriptionPlan', 'user');
        $plan = $order->items->firstWhere('item_type', 'subscription')?->subscriptionPlan;
        if (!$plan) {
            throw new \RuntimeException('Subscription plan is missing.');
        }

        $response = $this->createStripeSubscriptionSession($order, $secretKey, $plan);

        if (!$response->successful() && $this->isInvalidStripePriceResponse($response) && $plan->stripe_price_id) {
            Log::info('Resetting saved Stripe subscription price ID after checkout rejection.', [
                'plan_id' => $plan->id,
                'stripe_price_id' => $plan->stripe_price_id,
            ]);

            $plan->forceFill(['stripe_price_id' => null])->save();
            $response = $this->createStripeSubscriptionSession($order, $secretKey, $plan->refresh());
        }

        if (!$response->successful() || !$response->json('url')) {
            $this->logGatewayFailure('Stripe subscription checkout session could not be created.', $gateway, $response);
            throw new \RuntimeException('Stripe subscription checkout session could not be created. ' . $this->stripeErrorMessage($response));
        }

        $this->updatePendingTransaction($order, [
            'gateway_order_id' => $response->json('id'),
            'transaction_id' => $response->json('id'),
            'raw_response' => $response->json(),
        ]);

        return $response->json('url');
    }

    private function createStripeSubscriptionSession(Order $order, string $secretKey, SubscriptionPlan $plan)
    {
        $payload = [
            'mode' => 'subscription',
            'success_url' => route('payment.stripe.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', ['order' => $order->id]),
            'customer_email' => $order->user->email,
            'client_reference_id' => $order->order_number,
            'metadata[order_id]' => $order->id,
            'metadata[order_number]' => $order->order_number,
            'subscription_data[metadata][order_id]' => $order->id,
            'subscription_data[metadata][order_number]' => $order->order_number,
            'line_items[0][quantity]' => 1,
        ];

        if ($plan->stripe_price_id) {
            $payload['line_items[0][price]'] = $plan->stripe_price_id;
        } else {
            $interval = $this->recurringIntervalForPlan($plan);
            $productData = [
                'line_items[0][price_data][product_data][name]' => Str::limit($plan->name ?: 'Subscription Plan', 250, ''),
                'line_items[0][price_data][product_data][metadata][subscription_plan_id]' => (string) $plan->id,
                'line_items[0][price_data][product_data][metadata][subscription_plan_slug]' => (string) ($plan->slug ?: $plan->id),
            ];

            if (trim((string) $plan->description) !== '') {
                $productData['line_items[0][price_data][product_data][description]'] = Str::limit(strip_tags($plan->description), 1000, '');
            }

            $payload = array_merge($payload, $productData, [
                'line_items[0][price_data][currency]' => strtolower($plan->currency ?: 'USD'),
                'line_items[0][price_data][unit_amount]' => (int) round(((float) $plan->price) * 100),
                'line_items[0][price_data][recurring][interval]' => $interval['interval'],
                'line_items[0][price_data][recurring][interval_count]' => $interval['interval_count'],
            ]);
        }

        return Http::asForm()
            ->withToken($secretKey)
            ->post('https://api.stripe.com/v1/checkout/sessions', $payload);
    }

    private function createStripeCheckoutUrl(Order $order, PaymentGateway $gateway)
    {
        $secretKey = $this->stripeSecretKey($gateway);

        $response = Http::asForm()
            ->withToken($secretKey)
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode' => 'payment',
                'success_url' => route('payment.stripe.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['order' => $order->id]),
                'customer_email' => $order->user->email,
                'client_reference_id' => $order->order_number,
                'metadata[order_id]' => $order->id,
                'metadata[order_number]' => $order->order_number,
                'line_items[0][price_data][currency]' => strtolower($order->currency),
                'line_items[0][price_data][product_data][name]' => 'CEUTrainers Order ' . $order->order_number,
                'line_items[0][price_data][unit_amount]' => (int) round(((float) $order->grand_total) * 100),
                'line_items[0][quantity]' => 1,
            ]);

        if (!$response->successful() || !$response->json('url')) {
            $this->logGatewayFailure('Stripe checkout session could not be created.', $gateway, $response);
            throw new \RuntimeException('Stripe checkout session could not be created.');
        }

        $this->updatePendingTransaction($order, [
            'gateway_order_id' => $response->json('id'),
            'transaction_id' => $response->json('id'),
            'raw_response' => $response->json(),
        ]);

        return $response->json('url');
    }

    private function createPaypalApprovalUrl(Order $order, PaymentGateway $gateway)
    {
        $accessToken = $this->paypalAccessToken($gateway);
        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($this->paypalBaseUrl($gateway) . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => $order->order_number,
                    'custom_id' => (string) $order->id,
                    'amount' => [
                        'currency_code' => $order->currency,
                        'value' => number_format((float) $order->grand_total, 2, '.', ''),
                    ],
                ]],
                'application_context' => [
                    'brand_name' => 'CEUTrainers',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('payment.paypal.success', ['order' => $order->id]),
                    'cancel_url' => route('payment.cancel', ['order' => $order->id]),
                ],
            ]);

        if (!$response->successful()) {
            $this->logGatewayFailure('PayPal order could not be created.', $gateway, $response);
            throw new \RuntimeException('PayPal order could not be created.');
        }

        $paypalOrder = $response->json();
        $approvalUrl = collect($paypalOrder['links'] ?? [])->firstWhere('rel', 'approve')['href'] ?? null;
        if (!$approvalUrl) {
            throw new \RuntimeException('PayPal approval URL is missing.');
        }

        $this->updatePendingTransaction($order, [
            'gateway_order_id' => $paypalOrder['id'] ?? null,
            'transaction_id' => $paypalOrder['id'] ?? null,
            'raw_response' => $paypalOrder,
        ]);

        return $approvalUrl;
    }

    private function createPaypalSubscriptionApprovalUrl(Order $order, PaymentGateway $gateway)
    {
        $order->loadMissing('items.subscriptionPlan', 'user');
        $plan = $order->items->firstWhere('item_type', 'subscription')?->subscriptionPlan;
        if (!$plan) {
            throw new \RuntimeException('Subscription plan is missing.');
        }

        $accessToken = $this->paypalAccessToken($gateway);
        $paypalPlanId = $this->paypalPlanIdForSubscriptionPlan($plan, $gateway, $accessToken);

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($this->paypalBaseUrl($gateway) . '/v1/billing/subscriptions', [
                'plan_id' => $paypalPlanId,
                'custom_id' => (string) $order->id,
                'application_context' => [
                    'brand_name' => 'CEUTrainers',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'return_url' => route('payment.paypal.success', ['order' => $order->id]),
                    'cancel_url' => route('payment.cancel', ['order' => $order->id]),
                ],
                'subscriber' => [
                    'email_address' => $order->user->email,
                    'name' => [
                        'given_name' => Str::before($order->user->name, ' ') ?: $order->user->name,
                        'surname' => Str::after($order->user->name, ' ') ?: $order->user->name,
                    ],
                ],
            ]);

        if (!$response->successful()) {
            $this->logGatewayFailure('PayPal subscription could not be created.', $gateway, $response);
            throw new \RuntimeException('PayPal subscription could not be created.');
        }

        $paypalSubscription = $response->json();
        $approvalUrl = collect($paypalSubscription['links'] ?? [])->firstWhere('rel', 'approve')['href'] ?? null;
        if (!$approvalUrl) {
            throw new \RuntimeException('PayPal subscription approval URL is missing.');
        }

        $this->updatePendingTransaction($order, [
            'gateway_order_id' => $paypalSubscription['id'] ?? null,
            'transaction_id' => $paypalSubscription['id'] ?? null,
            'raw_response' => $paypalSubscription,
        ]);

        return $approvalUrl;
    }

    private function paypalPlanIdForSubscriptionPlan(SubscriptionPlan $plan, PaymentGateway $gateway, string $accessToken)
    {
        if ($plan->paypal_plan_id) {
            return $plan->paypal_plan_id;
        }

        $productId = $plan->paypal_product_id;
        if (!$productId) {
            $productResponse = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->paypalBaseUrl($gateway) . '/v1/catalogs/products', [
                    'name' => $plan->name,
                    'description' => Str::limit($plan->description ?: $plan->name, 120),
                    'type' => 'SERVICE',
                    'category' => 'EDUCATIONAL_AND_TEXTBOOKS',
                ]);

            if (!$productResponse->successful() || !$productResponse->json('id')) {
                $this->logGatewayFailure('PayPal subscription product could not be created.', $gateway, $productResponse);
                throw new \RuntimeException('PayPal subscription product could not be created.');
            }

            $productId = $productResponse->json('id');
            $plan->forceFill(['paypal_product_id' => $productId])->save();
        }

        $interval = $this->recurringIntervalForPlan($plan, true);
        $planResponse = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($this->paypalBaseUrl($gateway) . '/v1/billing/plans', [
                'product_id' => $productId,
                'name' => $plan->name,
                'description' => Str::limit($plan->description ?: $plan->name, 120),
                'status' => 'ACTIVE',
                'billing_cycles' => [[
                    'frequency' => [
                        'interval_unit' => strtoupper($interval['interval']),
                        'interval_count' => $interval['interval_count'],
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => number_format((float) $plan->price, 2, '.', ''),
                            'currency_code' => strtoupper($plan->currency ?: 'USD'),
                        ],
                    ],
                ]],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee_failure_action' => 'CONTINUE',
                    'payment_failure_threshold' => 3,
                ],
            ]);

        if (!$planResponse->successful() || !$planResponse->json('id')) {
            $this->logGatewayFailure('PayPal billing plan could not be created.', $gateway, $planResponse);
            throw new \RuntimeException('PayPal billing plan could not be created.');
        }

        $plan->forceFill(['paypal_plan_id' => $planResponse->json('id')])->save();

        return $plan->paypal_plan_id;
    }

    private function paypalAccessToken(PaymentGateway $gateway)
    {
        $clientId = $gateway->getSetting('client_id');
        $clientSecret = $gateway->getSetting('client_secret');
        if ($this->isPlaceholderGatewayValue($clientId) || $this->isPlaceholderGatewayValue($clientSecret)) {
            throw new \RuntimeException('PayPal credentials are missing.');
        }

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post($this->paypalBaseUrl($gateway) . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful() || !$response->json('access_token')) {
            $this->logGatewayFailure('PayPal access token could not be created.', $gateway, $response);
            throw new \RuntimeException('PayPal access token could not be created.');
        }

        return $response->json('access_token');
    }

    private function paypalBaseUrl(PaymentGateway $gateway)
    {
        return $gateway->mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    private function isPlaceholderGatewayValue(?string $value): bool
    {
        if (!is_string($value) || trim($value) === '') {
            return true;
        }

        $value = strtolower(trim($value));

        return str_contains($value, 'your_key_here')
            || str_contains($value, 'client_id_here')
            || str_contains($value, 'encrypted_value_here');
    }

    private function stripeSecretKey(PaymentGateway $gateway): string
    {
        $secretKey = trim((string) $gateway->getSetting('secret_key'));

        if ($this->isPlaceholderGatewayValue($secretKey)) {
            throw new \RuntimeException('Stripe secret key is missing.');
        }

        if (!str_starts_with($secretKey, 'sk_test_') && !str_starts_with($secretKey, 'sk_live_')) {
            throw new \RuntimeException('Stripe secret key is invalid. Use a Stripe Secret key that starts with sk_test_ or sk_live_.');
        }

        return $secretKey;
    }

    private function logGatewayFailure(string $message, PaymentGateway $gateway, $response): void
    {
        Log::warning($message, [
            'gateway' => $gateway->slug,
            'mode' => $gateway->mode,
            'status' => method_exists($response, 'status') ? $response->status() : null,
            'response' => method_exists($response, 'json') ? $response->json() : null,
        ]);
    }

    private function stripeErrorMessage($response): string
    {
        if (!method_exists($response, 'json')) {
            return '';
        }

        $message = $response->json('error.message');

        return $message ? 'Stripe said: ' . $message : '';
    }

    private function isInvalidStripePriceResponse($response): bool
    {
        if (!method_exists($response, 'json')) {
            return false;
        }

        $code = (string) $response->json('error.code');
        $param = (string) $response->json('error.param');
        $message = strtolower((string) $response->json('error.message'));

        return $code === 'resource_missing'
            || str_contains($param, 'price')
            || str_contains($message, 'no such price')
            || str_contains($message, 'price');
    }

    private function recurringIntervalForPlan(SubscriptionPlan $plan, bool $forPayPal = false)
    {
        $days = max((int) $plan->duration_days, 1);

        if ($days % 365 === 0) {
            return ['interval' => $forPayPal ? 'year' : 'year', 'interval_count' => max((int) ($days / 365), 1)];
        }

        if ($days % 30 === 0) {
            return ['interval' => $forPayPal ? 'month' : 'month', 'interval_count' => max((int) ($days / 30), 1)];
        }

        if ($days % 7 === 0) {
            return ['interval' => $forPayPal ? 'week' : 'week', 'interval_count' => max((int) ($days / 7), 1)];
        }

        return ['interval' => 'day', 'interval_count' => $days];
    }

    private function markOrderPaid(Order $order, ?PaymentGateway $gateway, array $transactionData = [])
    {
        if ($order->payment_status === 'paid') {
            return;
        }

        $order->loadMissing(['coupon', 'items.coursePricing', 'items.subscriptionPlan.courses', 'items.subscriptionPlan.industries', 'user']);
        $user = $order->user;

        foreach ($order->items as $orderItem) {
            if ($orderItem->item_type === 'subscription') {
                $plan = $orderItem->subscriptionPlan;
                if (!$plan) {
                    continue;
                }

                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'order_id' => $order->id,
                    'gateway_subscription_id' => $transactionData['gateway_subscription_id'] ?? null,
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addDays($plan->duration_days + $plan->free_extra_days)->toDateString(),
                    'renewal_date' => now()->addDays($plan->duration_days + $plan->free_extra_days)->toDateString(),
                    'auto_renew' => (bool) ($transactionData['auto_renew'] ?? false),
                    'status' => 'active',
                ]);

                foreach ($this->coursesForSubscription($plan) as $course) {
                    UserCourseAccess::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                            'access_source' => 'subscription',
                            'access_type' => 'full',
                        ],
                        [
                            'order_id' => $order->id,
                            'subscription_id' => $subscription->id,
                            'starts_at' => now(),
                            'expires_at' => now()->addDays($plan->duration_days + $plan->free_extra_days),
                            'status' => 'active',
                        ]
                    );
                }

                continue;
            }

            UserCourseAccess::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $orderItem->course_id,
                    'access_source' => 'single_purchase',
                    'access_type' => $orderItem->coursePricing && str_contains(strtolower($orderItem->coursePricing->category), 'recording') ? 'recording' : 'full',
                ],
                [
                    'order_id' => $order->id,
                    'starts_at' => now(),
                    'expires_at' => now()->addDays(365),
                    'status' => 'active',
                ]
            );
        }

        $order->update([
            'status' => 'paid',
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        PaymentTransaction::updateOrCreate(
            ['order_id' => $order->id, 'gateway_slug' => $gateway?->slug ?: $order->payment_gateway],
            [
                'gateway_id' => $gateway?->id,
                'transaction_id' => $transactionData['transaction_id'] ?? null,
                'gateway_order_id' => $transactionData['gateway_order_id'] ?? null,
                'gateway_payment_id' => $transactionData['gateway_payment_id'] ?? null,
                'payer_email' => $transactionData['payer_email'] ?? $user->email,
                'amount' => $order->grand_total,
                'currency' => $order->currency,
                'status' => 'succeeded',
                'raw_response' => $transactionData['raw_response'] ?? null,
                'paid_at' => now(),
            ]
        );

        $cart = Cart::where('user_id', $user->id)->where('status', 'active')->first();
        if ($cart) {
            $cart->update(['status' => 'checked_out']);
        }

        if ($order->coupon) {
            $order->coupon->increment('used_count');
            session()->forget('checkout_coupon_id');
        }
    }

    private function updatePendingTransaction(Order $order, array $data)
    {
        $order->transactions()
            ->where('status', 'pending')
            ->latest()
            ->first()
            ?->update($data);
    }

    private function gatewayForCheckout($slug)
    {
        return PaymentGateway::with('settings')
            ->where('slug', $slug)
            ->where('status', 1)
            ->orderByDesc('is_default')
            ->orderBy('sort_order')
            ->first();
    }

    private function orderBelongsToCurrentUser(Order $order)
    {
        return Auth::check() && (int) $order->user_id === (int) Auth::id();
    }

    private function hasMixedCheckoutItems($cartItems)
    {
        return $cartItems->pluck('item_type')->unique()->count() > 1;
    }

    private function validStripeWebhookSignature(Request $request, PaymentGateway $gateway)
    {
        $secret = $gateway->getSetting('webhook_secret');
        if (!$secret) {
            return true;
        }

        $signature = $request->header('Stripe-Signature');
        if (!$signature) {
            return false;
        }

        parse_str(str_replace(',', '&', $signature), $parts);
        if (empty($parts['t']) || empty($parts['v1'])) {
            return false;
        }

        $signedPayload = $parts['t'] . '.' . $request->getContent();
        $expected = hash_hmac('sha256', $signedPayload, $secret);

        return hash_equals($expected, $parts['v1']);
    }

    private function storeWebhookEvent($gatewaySlug, $eventId, $eventType, array $payload)
    {
        return WebhookEvent::firstOrCreate(
            ['gateway_slug' => $gatewaySlug, 'event_id' => $eventId],
            [
                'event_type' => $eventType,
                'payload' => $payload,
                'status' => 'pending',
                'created_at' => now(),
            ]
        );
    }

    private function extendSubscriptionFromWebhook($gatewaySubscriptionId, array $payload, $gatewaySlug)
    {
        $subscription = UserSubscription::with(['plan', 'user'])
            ->where('gateway_subscription_id', $gatewaySubscriptionId)
            ->first();

        if (!$subscription || !$subscription->plan) {
            return;
        }

        $currentEnd = $subscription->end_date && $subscription->end_date->isFuture()
            ? $subscription->end_date->copy()
            : now();

        $newEnd = $currentEnd->addDays($subscription->plan->duration_days + $subscription->plan->free_extra_days);

        $subscription->update([
            'end_date' => $newEnd->toDateString(),
            'renewal_date' => $newEnd->toDateString(),
            'auto_renew' => true,
            'status' => 'active',
        ]);

        PaymentTransaction::create([
            'order_id' => $subscription->order_id,
            'gateway_slug' => $gatewaySlug,
            'transaction_id' => data_get($payload, 'id'),
            'gateway_order_id' => $gatewaySubscriptionId,
            'gateway_payment_id' => data_get($payload, 'payment_intent') ?: data_get($payload, 'id'),
            'payer_email' => $subscription->user?->email,
            'amount' => data_get($payload, 'amount_paid')
                ? ((float) data_get($payload, 'amount_paid') / 100)
                : (float) $subscription->plan->price,
            'currency' => strtoupper(data_get($payload, 'currency') ?: $subscription->plan->currency ?: 'USD'),
            'status' => 'succeeded',
            'raw_response' => $payload,
            'paid_at' => now(),
        ]);
    }

    private function pauseSubscriptionFromWebhook($gatewaySubscriptionId, $status)
    {
        UserSubscription::where('gateway_subscription_id', $gatewaySubscriptionId)
            ->update([
                'status' => $status,
                'auto_renew' => false,
                'cancelled_at' => $status === 'cancelled' ? now() : null,
            ]);
    }

    /**
     * Get or create active cart for guest or authenticated user
     */
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'active']
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => session()->getId(), 'status' => 'active']
        );
    }

    /**
     * Merge guest session cart items into the database table upon login
     */
    private function mergeSessionCart()
    {
        if (Auth::check()) {
            $guestCart = Cart::where('session_id', session()->getId())
                ->where('status', 'active')
                ->first();

            if ($guestCart) {
                $userCart = Cart::firstOrCreate(
                    ['user_id' => Auth::id(), 'status' => 'active']
                );

                $guestItems = CartItem::where('cart_id', $guestCart->id)->get();
                foreach ($guestItems as $item) {
                    // Move item to user cart
                    CartItem::updateOrCreate(
                        [
                            'cart_id' => $userCart->id,
                            'course_id' => $item->course_id,
                            'subscription_plan_id' => $item->subscription_plan_id,
                        ],
                        [
                            'item_type' => $item->item_type,
                            'pricing_id' => $item->pricing_id,
                            'subscription_plan_id' => $item->subscription_plan_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,
                            'total_price' => $item->total_price,
                        ]
                    );
                }

                // Delete guest cart
                $guestCart->delete();
            }
        }
    }

    private function activeCouponForSubtotal($subtotal)
    {
        $couponId = session('checkout_coupon_id');
        if (!$couponId) {
            return null;
        }

        $coupon = Coupon::find($couponId);
        if (!$coupon || $this->couponValidationError($coupon, $subtotal)) {
            session()->forget('checkout_coupon_id');
            return null;
        }

        return $coupon;
    }

    private function couponValidationError(Coupon $coupon, $subtotal)
    {
        if (!$coupon->status) {
            return 'This coupon is inactive.';
        }

        if ($coupon->valid_from && now()->toDateString() < $coupon->valid_from->format('Y-m-d')) {
            return 'This coupon is not active yet.';
        }

        if ($coupon->valid_until && now()->toDateString() > $coupon->valid_until->format('Y-m-d')) {
            return 'This coupon has expired.';
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return 'This coupon usage limit has been reached.';
        }

        if ($coupon->min_order_amount && $subtotal < (float) $coupon->min_order_amount) {
            return 'Minimum order amount for this coupon is $' . number_format($coupon->min_order_amount, 2) . '.';
        }

        return null;
    }

    private function couponDiscount(Coupon $coupon, $subtotal)
    {
        if ($coupon->discount_type === 'percentage') {
            $discount = ($subtotal * (float) $coupon->discount_value) / 100;
        } else {
            $discount = (float) $coupon->discount_value;
        }

        if ($coupon->max_discount_amount) {
            $discount = min($discount, (float) $coupon->max_discount_amount);
        }

        return min($discount, $subtotal);
    }

    private function coursesForSubscription(SubscriptionPlan $plan)
    {
        $query = Course::where('subscription_enabled', 1);

        if ($plan->courses->isNotEmpty()) {
            $query->whereIn('id', $plan->courses->pluck('id'));
        } elseif ($plan->industries->isNotEmpty()) {
            $query->whereIn('industry_id', $plan->industries->pluck('id'));
        }

        if ($plan->max_course_access) {
            $query->limit($plan->max_course_access);
        }

        return $query->get();
    }
}
