<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\SubscriptionFeature;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = SubscriptionPlan::with('features')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        $features = SubscriptionFeature::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('subscription.index', compact('subscriptions', 'features'));
    }

    public function addToCart($id)
    {
        $plan = SubscriptionPlan::where('status', 'active')->findOrFail($id);
        $cart = $this->getOrCreateCart();

        CartItem::where('cart_id', $cart->id)
            ->where('item_type', 'course')
            ->delete();

        CartItem::where('cart_id', $cart->id)
            ->where('subscription_plan_id', $plan->id)
            ->delete();

        CartItem::create([
            'cart_id' => $cart->id,
            'item_type' => 'subscription',
            'subscription_plan_id' => $plan->id,
            'quantity' => 1,
            'unit_price' => (float)$plan->price,
            'total_price' => (float)$plan->price,
        ]);

        return redirect()->route('cart.index')->with('success', 'Subscription plan added to your cart successfully!');
    }

    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id(), 'status' => 'active']);
        }

        return Cart::firstOrCreate(['session_id' => session()->getId(), 'status' => 'active']);
    }
}
