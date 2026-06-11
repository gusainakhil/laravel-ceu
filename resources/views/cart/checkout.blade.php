@extends('layouts.app')

@section('title', 'Checkout | CEUTrainers')

@section('styles')
<style>
    .checkout-hero {
        background: #f4fafa;
        min-height: 310px;
        overflow: hidden;
        padding: 88px 0 70px;
        position: relative;
        text-align: center;
    }

    .checkout-hero::before,
    .checkout-hero::after {
        border: 1px solid rgba(19, 35, 31, 0.08);
        border-radius: 50%;
        content: "";
        height: 360px;
        position: absolute;
        width: 360px;
    }

    .checkout-hero::before {
        left: -80px;
        top: -170px;
    }

    .checkout-hero::after {
        bottom: -170px;
        right: -80px;
    }

    .checkout-dots {
        background-image: radial-gradient(#1ab69d 2px, transparent 2px);
        background-size: 20px 20px;
        height: 160px;
        left: 15%;
        opacity: 0.8;
        position: absolute;
        top: 105px;
        width: 190px;
    }

    .checkout-hero h1 {
        color: #171717;
        font-size: 56px;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }

    .checkout-breadcrumb {
        align-items: center;
        color: #171717;
        display: flex;
        font-size: 18px;
        font-weight: 700;
        gap: 12px;
        justify-content: center;
        position: relative;
        z-index: 1;
    }

    .checkout-breadcrumb a {
        color: #171717;
    }

    .checkout-page {
        background: #fff;
        padding: 70px 0 90px;
    }

    .coupon-strip {
        border: 1px solid #dedede;
        border-radius: 6px;
        color: #202020;
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 70px;
        padding: 24px 32px;
    }

    .coupon-strip button {
        background: transparent;
        border: 0;
        color: #1ab69d;
        font-weight: 800;
        padding: 0;
    }

    .coupon-form {
        display: none;
        margin-top: 18px;
    }

    .coupon-form.is-open {
        display: flex;
        gap: 12px;
    }

    .coupon-form .form-control {
        border: 1px solid #dedede;
        border-radius: 6px;
        height: 48px;
    }

    .coupon-form .btn {
        border-radius: 6px;
        min-width: 120px;
    }

    .applied-coupon {
        color: #1ab69d;
        display: block;
        font-size: 14px;
        margin-top: 12px;
    }

    .applied-coupon form {
        display: inline;
    }

    .applied-coupon button {
        color: #ee4a7f;
        font-size: 14px;
        margin-left: 8px;
    }

    .checkout-title {
        color: #171717;
        font-size: 34px;
        font-weight: 900;
        margin-bottom: 36px;
    }

    .billing-form label {
        color: #242424;
        display: block;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .billing-form .form-control {
        background: #fbfbfb;
        border: 1px solid #dedede;
        border-radius: 6px;
        color: #171717;
        font-size: 17px;
        height: 54px;
        padding: 12px 18px;
    }

    .billing-form .form-control:focus {
        border-color: #1ab69d;
        box-shadow: 0 0 0 3px rgba(26, 182, 157, 0.12);
    }

    .billing-form .field-gap {
        margin-bottom: 30px;
    }

    .order-card {
        border: 1px solid #dedede;
        border-radius: 6px;
        padding: 54px 60px;
        position: sticky;
        top: 110px;
    }

    .order-card h3 {
        color: #171717;
        font-size: 26px;
        font-weight: 900;
        margin-bottom: 38px;
    }

    .order-item-title {
        color: #1ab69d;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.55;
        margin-bottom: 22px;
    }

    .order-line {
        align-items: center;
        border-bottom: 1px solid #e7e7e7;
        display: flex;
        justify-content: space-between;
        padding: 18px 0;
    }

    .order-line:last-of-type {
        border-bottom: 0;
    }

    .order-line span,
    .order-line strong {
        color: #242424;
        font-size: 18px;
    }

    .order-line.total strong,
    .order-line.total .amount {
        color: #1ab69d;
        font-weight: 900;
    }

    .order-meta {
        color: #6d6d6d;
        font-size: 15px;
        margin-bottom: 12px;
    }

    .checkout-submit {
        border: 0;
        margin-top: 34px;
        width: 100%;
    }

    .payment-methods {
        border-top: 1px solid #e7e7e7;
        margin-top: 24px;
        padding-top: 24px;
    }

    .payment-option {
        align-items: center;
        border: 1px solid #dedede;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        padding: 14px 16px;
    }

    .payment-option:has(input:checked) {
        border-color: #1ab69d;
        box-shadow: 0 0 0 3px rgba(26, 182, 157, 0.12);
    }

    .payment-option input {
        margin: 0;
    }

    .payment-option span {
        color: #242424;
        font-size: 17px;
        font-weight: 800;
    }

    @media (max-width: 991px) {
        .order-card {
            margin-top: 30px;
            padding: 32px;
            position: static;
        }
    }

    @media (max-width: 767px) {
        .checkout-hero {
            min-height: 240px;
            padding: 62px 0 52px;
        }

        .checkout-hero h1 {
            font-size: 40px;
        }

        .checkout-dots {
            display: none;
        }

        .coupon-strip {
            margin-bottom: 42px;
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<section class="checkout-hero">
    <div class="checkout-dots"></div>
    <div class="container">
        <h1>Checkout</h1>
        <div class="checkout-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>Checkout</span>
        </div>
    </div>
</section>

<section class="checkout-page">
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                {{ $errors->first() }}
                @error('email')
                    <a href="{{ route('login') }}" class="fw-bold ms-2">Login here</a>
                @enderror
            </div>
        @endif

        <div class="coupon-strip">
            Have a coupon?
            <button type="button" id="toggleCoupon">Click here to enter your code</button>
            @if($coupon)
                <span class="applied-coupon">
                    Applied: <strong>{{ $coupon->code }}</strong> (-${{ number_format($discount, 2) }})
                    <form action="{{ route('cart.coupon.remove') }}" method="POST">
                        @csrf
                        <button type="submit">Remove</button>
                    </form>
                </span>
            @endif
        </div>

        <form action="{{ route('cart.coupon.apply') }}" method="POST" class="coupon-form {{ $errors->has('coupon_code') ? 'is-open' : '' }}" id="couponForm">
            @csrf
            <input type="text" name="coupon_code" class="form-control" placeholder="Enter coupon code" value="{{ old('coupon_code') }}">
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>

        <form action="{{ route('cart.checkout.process') }}" method="POST">
            @csrf
            <div class="row g-5">
                <div class="col-lg-7">
                    <h2 class="checkout-title">Billing Details</h2>

                    <div class="billing-form">
                        <div class="row">
                            <div class="col-md-6 field-gap">
                                <label>Full Name*</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', optional(Auth::user())->name) }}" required>
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Email Address*</label>
                                <input type="email" name="email" id="checkoutEmail" class="form-control" value="{{ old('email', optional(Auth::user())->email) }}" {{ Auth::check() ? 'readonly' : 'required' }}>
                                @guest
                                <div id="emailCheckMsg" style="display:none; margin-top:8px; font-size:14px;"></div>
                                @endguest
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', optional(Auth::user())->company_name) }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Job Title</label>
                                <input type="text" name="job_title" class="form-control" value="{{ old('job_title', optional(Auth::user())->job_title) }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', optional(Auth::user())->phone) }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', 'United States') }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', optional($billingAddress)->city) }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', optional($billingAddress)->state) }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Address</label>
                                <input type="text" name="address_line_1" class="form-control" value="{{ old('address_line_1', optional($billingAddress)->address_line_1) }}">
                            </div>
                            <div class="col-md-6 field-gap">
                                <label>Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', optional($billingAddress)->postal_code) }}">
                            </div>

                        </div>
                    </div>

                    @php
                        $attendeeItems = $cartItems->filter(function($item) {
                            return $item->item_type !== 'subscription' && (int) ($item->quantity ?? 1) >= 2;
                        });
                    @endphp

                    @if($attendeeItems->isNotEmpty())
                        <!-- Attendees Section -->
                        <h2 class="checkout-title mt-5">Attendee Details</h2>
                        <div class="billing-form">
                            @foreach($attendeeItems as $item)
                                @php
                                    $title = optional($item->course)->title;
                                    $quantity = (int) ($item->quantity ?? 1);
                                @endphp
                                <div class="mb-3 p-3" style="background: #fbfbfb; border-radius: 6px; border: 1px solid #dedede;">
                                    <h6 class="mb-2" style="color: #1ab69d; font-weight: 600; font-size: 13px;">{{ $title ?: 'Registration' }} ({{ $quantity }} attendees)</h6>
                                    
                                    @for($i = 1; $i <= $quantity; $i++)
                                        @php
                                            $attendeeKey = "item_" . $item->id . "_attendee_" . $i;
                                        @endphp
                                        <div class="row mb-2" style="padding: 10px; background: white; border-radius: 6px; border: 1px solid #e7e7e7;">
                                            <h6 class="col-12 mb-2" style="color: #171717; font-size: 12px;">Attendee #{{ $i }}</h6>
                                            
                                            <div class="col-md-6" style="margin-bottom: 8px;">
                                                <label style="font-size: 11px; margin-bottom: 4px; display: block;">Full Name*</label>
                                                <input 
                                                    type="text" 
                                                    name="attendees[{{ $attendeeKey }}][name]" 
                                                    class="form-control" 
                                                    placeholder="Full Name" 
                                                    style="font-size: 12px; padding: 6px 8px; height: auto;"
                                                    value="{{ old('attendees.' . $attendeeKey . '.name') }}"
                                                    required
                                                >
                                            </div>

                                            <div class="col-md-6" style="margin-bottom: 8px;">
                                                <label style="font-size: 11px; margin-bottom: 4px; display: block;">Email Address*</label>
                                                <input 
                                                    type="email" 
                                                    name="attendees[{{ $attendeeKey }}][email]" 
                                                    class="form-control" 
                                                    placeholder="Email Address" 
                                                    style="font-size: 12px; padding: 6px 8px; height: auto;"
                                                    value="{{ old('attendees.' . $attendeeKey . '.email') }}"
                                                    required
                                                >
                                            </div>

                                            <div class="col-md-6" style="margin-bottom: 8px;">
                                                <label style="font-size: 11px; margin-bottom: 4px; display: block;">Phone</label>
                                                <input 
                                                    type="text" 
                                                    name="attendees[{{ $attendeeKey }}][phone]" 
                                                    class="form-control" 
                                                    placeholder="Phone Number" 
                                                    style="font-size: 12px; padding: 6px 8px; height: auto;"
                                                    value="{{ old('attendees.' . $attendeeKey . '.phone') }}"
                                                >
                                            </div>

                                            <div class="col-md-6" style="margin-bottom: 8px;">
                                                <label style="font-size: 11px; margin-bottom: 4px; display: block;">Job Title</label>
                                                <input 
                                                    type="text" 
                                                    name="attendees[{{ $attendeeKey }}][job_title]" 
                                                    class="form-control" 
                                                    placeholder="Job Title" 
                                                    style="font-size: 12px; padding: 6px 8px; height: auto;"
                                                    value="{{ old('attendees.' . $attendeeKey . '.job_title') }}"
                                                >
                                            </div>

                                            <input type="hidden" name="attendees[{{ $attendeeKey }}][item_id]" value="{{ $item->id }}">
                                        </div>
                                    @endfor
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-lg-5">
                    <div class="order-card">
                        <h3>Your Orders</h3>

                        @foreach($cartItems as $item)
                            @php
                                $isSubscription = $item->item_type === 'subscription';
                                $title = $isSubscription ? optional($item->subscriptionPlan)->name : optional($item->course)->title;
                                $meta = $isSubscription ? 'Subscription plan' : optional($item->coursePricing)->label;
                            @endphp
                            <div class="mb-4">
                                <div class="order-item-title">{{ $title ?: 'Cart Item' }}</div>
                                <div class="order-meta">{{ $meta ?: 'Standard Registration' }}</div>
                                <div class="order-line">
                                    <span>{{ $isSubscription ? 'Plan' : 'Registration' }}</span>
                                    <strong>${{ number_format($item->total_price, 2) }}</strong>
                                </div>
                            </div>
                        @endforeach

                        <div class="order-line">
                            <strong>Sub Total</strong>
                            <strong>${{ number_format($subtotal, 2) }}</strong>
                        </div>
                        <div class="order-line">
                            <strong>Coupon Applied</strong>
                            <span>{{ $discount > 0 ? '-$' . number_format($discount, 2) : '$0' }}</span>
                        </div>
                        <div class="order-line total">
                            <strong>Order Total</strong>
                            <span class="amount">${{ number_format($total, 2) }}</span>
                        </div>

                        <div class="payment-methods">
                            <h3 class="mb-3">Payment Method</h3>
                            @forelse($gateways as $gateway)
                                <label class="payment-option">
                                    <input
                                        type="radio"
                                        name="payment_gateway"
                                        value="{{ $gateway->slug }}"
                                        {{ old('payment_gateway', optional($gateways->first())->slug) === $gateway->slug ? 'checked' : '' }}
                                        required
                                    >
                                    <span>{{ $gateway->name }}</span>
                                </label>
                            @empty
                                <div class="alert alert-danger mb-0">
                                    No active payment gateway is configured.
                                </div>
                            @endforelse
                            @error('payment_gateway')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="edu-btn btn-medium checkout-submit">
                            Complete Checkout <i class="icon-4"></i>
                        </button>

                        @guest
                            <p class="mt-3 mb-0 text-center">
                                Already have an account?
                                <a href="{{ route('login') }}" class="fw-bold">Login to checkout</a>
                            </p>
                        @endguest
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.getElementById('toggleCoupon')?.addEventListener('click', function() {
        document.getElementById('couponForm')?.classList.toggle('is-open');
    });

    @guest
    (function() {
        const emailInput = document.getElementById('checkoutEmail');
        const msgBox = document.getElementById('emailCheckMsg');
        if (!emailInput || !msgBox) return;

        let timer = null;

        emailInput.addEventListener('input', function() {
            clearTimeout(timer);
            msgBox.style.display = 'none';
            msgBox.innerHTML = '';

            const email = this.value.trim();
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return;

            timer = setTimeout(function() {
                fetch('{{ route("cart.checkout.check-email") }}?email=' + encodeURIComponent(email))
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.exists) {
                            msgBox.innerHTML = 'An account with this email already exists. <a href="{{ route("login") }}?redirect={{ urlencode(route("cart.checkout")) }}" class="fw-bold" style="color:#1ab69d;">Click here to login</a> and continue checkout.';
                            msgBox.style.color = '#ee4a7f';
                            msgBox.style.display = 'block';
                        }
                    })
                    .catch(function() {});
            }, 600);
        });
    })();
    @endguest
</script>
@endsection
