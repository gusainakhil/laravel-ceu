<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAddress;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to view your dashboard.');
        }

        $user = Auth::user()->load([
            'orders.items.course',
            'orders.items.subscriptionPlan',
            'subscriptions.plan',
            'courseAccesses.course',
            'addresses',
        ]);

        // Retrieve billing and shipping addresses
        $billingAddress = $user->addresses->where('type', 'billing')->first();
        $shippingAddress = $user->addresses->where('type', 'shipping')->first();

        return view('dashboard.index', [
            'user' => $user,
            'orders' => $user->orders->sortByDesc('created_at'),
            'subscriptions' => $user->subscriptions->sortByDesc('created_at'),
            'courseAccesses' => $user->courseAccesses->sortByDesc('created_at'),
            'billingAddress' => $billingAddress,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Update customer profile basic info & avatar.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'company_name', 'job_title']);

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . $user->id . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('uploads/avatars'), $avatarName);
            $data['avatar'] = asset('uploads/avatars/' . $avatarName);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile information updated successfully.');
    }

    /**
     * Update customer billing & shipping addresses.
     */
    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // Billing fields
            'billing_name' => 'required|string|max:255',
            'billing_phone' => 'nullable|string|max:30',
            'billing_company' => 'nullable|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_address_2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_country' => 'required|string|max:100',
            'billing_postal_code' => 'required|string|max:20',
        ]);

        // Update Billing Address
        $user->addresses()->updateOrCreate(
            ['type' => 'billing'],
            [
                'name' => $request->billing_name,
                'phone' => $request->billing_phone,
                'company_name' => $request->billing_company,
                'address_line_1' => $request->billing_address_1,
                'address_line_2' => $request->billing_address_2,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'country' => $request->billing_country,
                'postal_code' => $request->billing_postal_code,
                'is_default' => 1,
            ]
        );

        if ($request->has('same_as_billing')) {
            // Mirror billing address to shipping
            $user->addresses()->updateOrCreate(
                ['type' => 'shipping'],
                [
                    'name' => $request->billing_name,
                    'phone' => $request->billing_phone,
                    'company_name' => $request->billing_company,
                    'address_line_1' => $request->billing_address_1,
                    'address_line_2' => $request->billing_address_2,
                    'city' => $request->billing_city,
                    'state' => $request->billing_state,
                    'country' => $request->billing_country,
                    'postal_code' => $request->billing_postal_code,
                    'is_default' => 1,
                ]
            );
        } else {
            // Optional distinct shipping validations
            $request->validate([
                'shipping_name' => 'required|string|max:255',
                'shipping_phone' => 'nullable|string|max:30',
                'shipping_company' => 'nullable|string|max:255',
                'shipping_address_1' => 'required|string|max:255',
                'shipping_address_2' => 'nullable|string|max:255',
                'shipping_city' => 'required|string|max:100',
                'shipping_state' => 'required|string|max:100',
                'shipping_country' => 'required|string|max:100',
                'shipping_postal_code' => 'required|string|max:20',
            ]);

            $user->addresses()->updateOrCreate(
                ['type' => 'shipping'],
                [
                    'name' => $request->shipping_name,
                    'phone' => $request->shipping_phone,
                    'company_name' => $request->shipping_company,
                    'address_line_1' => $request->shipping_address_1,
                    'address_line_2' => $request->shipping_address_2,
                    'city' => $request->shipping_city,
                    'state' => $request->shipping_state,
                    'country' => $request->shipping_country,
                    'postal_code' => $request->shipping_postal_code,
                    'is_default' => 0,
                ]
            );
        }

        return redirect()->back()->with('success', 'Addresses updated successfully.');
    }

    /**
     * Update customer password safely.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Show premium print-ready invoice for the student.
     */
    public function showInvoice($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to view your invoice.');
        }

        $order = \App\Models\Order::with(['items.course', 'user.addresses', 'transactions'])->findOrFail($id);

        // Security Check: Only the student who placed the order can view this
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Decrypt / Decode address snapshot from notes if present
        $billingAddress = null;
        if (!empty($order->notes)) {
            $notesData = json_decode($order->notes, true);
            if (is_array($notesData) && isset($notesData['address_snapshot'])) {
                $billingAddress = (object) $notesData['address_snapshot'];
            }
        }

        if (!$billingAddress) {
            $billingAddress = $order->user->addresses->where('type', 'billing')->first() 
                ?? $order->user->addresses->first();
        }

        $transaction = $order->transactions->where('status', 'succeeded')->first() 
            ?? $order->transactions->first();

        return view('dashboard.invoice', [
            'order' => $order,
            'billingAddress' => $billingAddress,
            'transaction' => $transaction,
        ]);
    }
}
