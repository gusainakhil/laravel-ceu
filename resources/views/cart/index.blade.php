@extends('layouts.app')

@section('title', 'Cart | CEUTrainers')

@section('styles')
<style>
    .cart-hero {
        background: #f4fafa;
        min-height: 200px;
        overflow: hidden;
        padding: 50px 0 40px;
        position: relative;
        text-align: center;
    }

    .cart-hero::before,
    .cart-hero::after {
        border: 1px solid rgba(19, 35, 31, 0.08);
        border-radius: 50%;
        content: "";
        height: 330px;
        position: absolute;
        width: 330px;
    }

    .cart-hero::before {
        left: -90px;
        top: -170px;
    }

    .cart-hero::after {
        bottom: -180px;
        right: -90px;
    }

    .cart-dots {
        background-image: radial-gradient(#1ab69d 2px, transparent 2px);
        background-size: 19px 19px;
        height: 145px;
        left: 15%;
        opacity: 0.75;
        position: absolute;
        top: 96px;
        width: 175px;
    }

    .cart-hero h1 {
        color: #171717;
        font-size: 42px;
        font-weight: 600;
        line-height: 1;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .cart-breadcrumb {
        align-items: center;
        color: #171717;
        display: flex;
        font-size: 14px;
        font-weight: 600;
        gap: 8px;
        justify-content: center;
        position: relative;
        z-index: 1;
    }

    .cart-page {
        background: #fff;
        padding: 40px 0 60px;
    }

    .cart-panel,
    .cart-summary {
        border: 1px solid #dedede;
        border-radius: 6px;
        background: #fff;
    }

    .cart-panel {
        padding: 12px 0;
    }

    .cart-item {
        align-items: center;
        border-bottom: 1px solid #ededed;
        display: grid;
        gap: 18px;
        grid-template-columns: 36px minmax(0, 1fr) 180px 120px;
        padding: 18px 22px;
    }

    .cart-item:last-child {
        border-bottom: 0;
    }

    .remove-cart {
        align-items: center;
        background: transparent;
        border: 0;
        color: #171717;
        display: inline-flex;
        font-size: 22px;
        height: 36px;
        justify-content: center;
        padding: 0;
        width: 36px;
    }

    .remove-cart:hover {
        color: #ee4a7f;
    }

    .cart-item-title {
        color: #171717;
        display: inline-block;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.4;
        max-width: 470px;
    }

    .cart-item-title:hover {
        color: #1ab69d;
    }

    .cart-badge {
        background: #e7f8f5;
        border-radius: 999px;
        color: #1ab69d;
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
        padding: 5px 10px;
        vertical-align: middle;
    }

    .cart-item-detail {
        color: #333;
        font-size: 13px;
    }

    .cart-item-price {
        color: #10b981;
        font-size: 18px;
        font-weight: 600;
        text-align: right;
        white-space: nowrap;
    }

    .cart-summary {
        padding: 24px;
        position: sticky;
        top: 110px;
    }

    .cart-summary h3 {
        color: #171717;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .summary-line {
        align-items: flex-start;
        border-bottom: 1px solid #e7e7e7;
        display: flex;
        gap: 14px;
        justify-content: space-between;
        padding: 12px 0;
    }

    .summary-name {
        color: #171717;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
    }

    .summary-price {
        color: #666;
        font-size: 13px;
        white-space: nowrap;
    }

    .summary-total {
        align-items: center;
        display: flex;
        justify-content: space-between;
        padding: 16px 0 20px;
    }

    .summary-total strong {
        color: #171717;
        font-size: 16px;
        font-weight: 600;
    }

    .summary-total span {
        color: #10b981;
        font-size: 20px;
        font-weight: 600;
    }

    .cart-actions {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .continue-link {
        align-items: center;
        border: 1px solid #dedede;
        border-radius: 6px;
        color: #171717;
        display: inline-flex;
        font-weight: 600;
        font-size: 13px;
        justify-content: center;
        min-height: 44px;
        padding: 10px 18px;
        text-align: center;
    }

    .empty-cart {
        padding: 70px 30px;
        text-align: center;
    }

    .empty-cart i {
        color: #1ab69d;
        font-size: 54px;
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        font-size: 30px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .empty-cart p {
        color: #666;
        font-size: 17px;
        margin-bottom: 28px;
    }

    .empty-cart .edu-btn {
        align-items: center;
        display: inline-flex;
        justify-content: center;
        line-height: 1;
        min-width: 210px;
        text-align: center;
    }

    .cart-summary .edu-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: 0 !important;
        color: #fff !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        height: auto !important;
        min-height: 44px !important;
        padding: 10px 16px !important;
        margin-top: 16px !important;
    }

    .cart-summary .edu-btn:hover {
        opacity: 0.95;
    }

    @media (max-width: 1199px) {
        .cart-item {
            grid-template-columns: 36px minmax(0, 1fr) 140px 110px;
        }
    }

    @media (max-width: 991px) {
        .cart-summary {
            margin-top: 28px;
            position: static;
        }
    }

    @media (max-width: 767px) {
        .cart-hero {
            min-height: 160px;
            padding: 40px 0 30px;
        }

        .cart-hero h1 {
            font-size: 32px;
        }

        .cart-dots {
            display: none;
        }

        .cart-item {
            align-items: flex-start;
            grid-template-columns: 36px 1fr;
            padding: 24px 20px;
        }

        .cart-item-detail,
        .cart-item-price {
            grid-column: 2;
            text-align: left;
        }

        .cart-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<section class="cart-hero">
    <div class="cart-dots"></div>
    <div class="container">
        <h1>Cart</h1>
        <div class="cart-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>Cart</span>
        </div>
    </div>
</section>

<section class="cart-page">
    <div class="container">
        @if(!empty($cartItems) && count($cartItems) > 0)
            @php
                $allPrice = 0;
            @endphp

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-panel">
                        @foreach($cartItems as $item)
                            @php
                                $isSubscription = $item->item_type === 'subscription';
                                $title = $isSubscription ? optional($item->subscriptionPlan)->name : optional($item->course)->title;
                                $subtitle = $isSubscription ? optional($item->subscriptionPlan)->description : optional($item->coursePricing)->label;
                                $itemSubtotal = (float) $item->total_price;
                                $allPrice += $itemSubtotal;
                            @endphp
                            <div class="cart-item">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="remove-cart" aria-label="Remove {{ $title ?: 'item' }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>

                                <div>
                                    @if($isSubscription)
                                        <a href="{{ route('subscription.index') }}" class="cart-item-title">{{ $title ?: 'Subscription Plan' }}</a>
                                        <span class="cart-badge">Subscription</span>
                                    @else
                                        <a href="{{ $item->course ? route('course.show', $item->course->slug) : route('webinar.index') }}" class="cart-item-title">{{ $title ?: 'Course' }}</a>
                                    @endif
                                </div>

                                <div class="cart-item-detail">
                                    {{ $subtitle ?: 'Standard Registration' }}
                                </div>

                                <div class="cart-item-price">
                                    ${{ number_format($itemSubtotal, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="cart-actions">
                        <a href="{{ route('webinar.index') }}" class="continue-link">Continue Shopping</a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h3>Cart Totals</h3>

                        @foreach($cartItems as $item)
                            @php
                                $isSubscription = $item->item_type === 'subscription';
                                $title = $isSubscription ? optional($item->subscriptionPlan)->name : optional($item->course)->title;
                            @endphp
                            <div class="summary-line">
                                <div class="summary-name">{{ $title ?: 'Cart Item' }}</div>
                                <div class="summary-price">${{ number_format($item->total_price, 2) }}</div>
                            </div>
                        @endforeach

                        <div class="summary-total">
                            <strong>Order Total</strong>
                            <span>${{ number_format($allPrice, 2) }}</span>
                        </div>

                        <form action="{{ route('cart.checkout') }}" method="GET">
                            <button type="submit" class="edu-btn btn-medium w-100 text-center" style="border: 0;">
                                Proceed to Checkout <i class="icon-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <i class="fa fa-shopping-cart"></i>
                <h3>Your Cart is Empty</h3>
                <p>Add a webinar or subscription plan to continue checkout.</p>
                <a href="{{ route('webinar.index') }}" class="edu-btn btn-medium">Go to Webinar <i class="icon-4"></i></a>
            </div>
        @endif
    </div>
</section>
@endsection
