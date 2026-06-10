@extends('layouts.app')

@section('title', 'Subscription Plans | CEUTrainers')

@section('styles')
<style>
    .plans-section,
    .compare-section,
    .benefits-section {
        padding: 80px 0;
        background-color: #f8fafc;
        position: relative;
    }

    .plans-section {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f7f6 100%);
    }

    .section-kicker {
        color: #1ab69d;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 8px;
    }

    .section-heading {
        color: #0f172a;
        font-size: 34px;
        font-weight: 700;
        margin: 8px 0 12px;
        letter-spacing: -0.5px;
    }

    .section-copy {
        color: #475569;
        font-size: 16px;
        line-height: 1.7;
        margin: 0;
    }

    .plan-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.04), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 36px 30px;
        position: relative;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .plan-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -10px rgba(26, 182, 157, 0.12), 0 0 0 1px rgba(26, 182, 157, 0.08);
        border-color: rgba(26, 182, 157, 0.3);
    }

    .plan-card.is-popular {
        border-color: #1ab69d;
        background: linear-gradient(180deg, #ffffff 0%, #f3fcfb 100%);
        box-shadow: 0 20px 35px -10px rgba(26, 182, 157, 0.16);
    }

    .popular-badge {
        background: linear-gradient(135deg, #1ab69d 0%, #0d9488 100%);
        border-radius: 999px;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 5px 12px;
        position: absolute;
        right: 24px;
        top: 24px;
        box-shadow: 0 4px 10px rgba(26, 182, 157, 0.2);
    }

    .plan-name {
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
        padding-right: 92px;
        letter-spacing: -0.3px;
    }

    .plan-description {
        color: #475569;
        font-size: 14.5px;
        line-height: 1.6;
        min-height: 80px;
    }

    .plan-price {
        align-items: baseline;
        display: flex;
        gap: 4px;
        margin: 24px 0 6px;
    }

    .plan-price .currency {
        color: #1ab69d;
        font-size: 24px;
        font-weight: 600;
    }

    .plan-price .amount {
        color: #0f172a;
        font-size: 44px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .plan-duration {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 22px;
        font-weight: 500;
    }

    .plan-features {
        border-top: 1px solid #f1f5f9;
        list-style: none;
        margin: 0 0 28px;
        padding: 22px 0 0;
        flex-grow: 1;
    }

    .plan-features li {
        align-items: center;
        color: #334155;
        display: flex;
        font-size: 14.5px;
        gap: 12px;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .plan-features i {
        color: #1ab69d;
        font-size: 12px;
        background-color: #e6f8f5;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .plan-card form {
        width: 100%;
        margin-top: auto;
        display: block;
    }

    .plan-card .edu-btn {
        background: #1ab69d;
        color: #fff;
        border: 0;
        border-radius: 8px;
        padding: 16px 20px;
        width: 100% !important;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(26, 182, 157, 0.15);
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
    }

    .plan-card .edu-btn i {
        position: static !important;
        margin: 0 !important;
        transform: none !important;
        font-size: 14px !important;
        display: inline-block !important;
    }

    .plan-card .edu-btn:hover {
        background: #159b85;
        box-shadow: 0 6px 16px rgba(26, 182, 157, 0.25);
    }

    .plan-card.is-popular .edu-btn {
        background: linear-gradient(135deg, #1ab69d 0%, #0d9488 100%);
    }

    .compare-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .comparison-table {
        margin: 0;
    }

    .comparison-table th,
    .comparison-table td {
        border-color: #f1f5f9;
        font-size: 14.5px;
        padding: 18px 20px;
        vertical-align: middle;
    }

    .comparison-table thead th {
        background: #f8fafc;
        color: #0f172a;
        font-weight: 600;
    }

    .comparison-table tbody th {
        color: #334155;
        font-weight: 500;
        min-width: 250px;
    }

    .check-icon {
        color: #1ab69d;
        font-size: 14px;
        background-color: #e6f8f5;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .dash-icon {
        color: #94a3b8;
        font-size: 14px;
    }

    .benefit-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        height: 100%;
        padding: 30px;
        transition: all 0.3s ease;
    }

    .benefit-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.06);
    }

    .benefit-card i {
        color: #1ab69d;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
        background: #e6f8f5;
        width: 50px;
        height: 50px;
        border-radius: 12px;
    }

    .benefit-card h5 {
        color: #0f172a;
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .benefit-card p {
        color: #475569;
        font-size: 14.5px;
        line-height: 1.65;
        margin: 0;
    }

    @media (max-width: 767px) {
        .plans-section,
        .compare-section,
        .benefits-section {
            padding: 48px 0;
        }
    }
</style>
@endsection

@section('content')
<div class="edu-breadcrumb-area" style="background: linear-gradient(180deg, #f8fafc 0%, #edf5f4 100%); border-bottom: 1px solid #e2e8f0; padding: 80px 0 60px;">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title text-center">
                <h1 class="title" style="font-size: 42px; font-weight: 700; color: #0f172a; margin-bottom: 16px; letter-spacing: -1px;">CEU Subscription Plans</h1>
                <p style="font-size: 18px; color: #475569; max-width: 700px; margin: 0 auto 24px; line-height: 1.6; font-weight: 400;">
                    Unlock the learning you need — when you need it. Our subscription plans give you full access to all live and recorded webinars, e-Transcripts, and upcoming events.
                </p>
                <span class="shape-line" style="color:#1ab69d; font-size: 20px;"><i class="icon-19"></i></span>
            </div>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1"><span></span></li>
        <li class="shape-2 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape" /></li>
        <li class="shape-3 scene"><img data-depth="-2" src="{{ asset('assets/images/about/shape-15.png') }}" alt="shape" /></li>
        <li class="shape-4"><span></span></li>
        <li class="shape-5 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-07.png') }}" alt="shape" /></li>
    </ul>
</div>

<section class="plans-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7">
                <span class="section-kicker">Plans</span>
                <h2 class="section-heading">Pick the right access level</h2>
                <p class="section-copy">Each plan can include live webinars, recordings, transcripts, priority support, specific course mappings, or full subscription-enabled course access.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($subscriptions as $plan)
            <div class="col-xl-4 col-md-6">
                <div class="plan-card {{ $plan->is_popular ? 'is-popular' : '' }}">
                    @if($plan->is_popular)
                        <span class="popular-badge">POPULAR</span>
                    @endif

                    <h3 class="plan-name">{{ $plan->name }}</h3>
                    <p class="plan-description">{{ $plan->description ?: 'Professional learning access for CEUTrainers courses and resources.' }}</p>

                    <div class="plan-price">
                        <span class="currency">$</span>
                        <span class="amount">{{ number_format($plan->price, 0) }}</span>
                    </div>
                    <div class="plan-duration">{{ $plan->duration_days + $plan->free_extra_days }} days access</div>

                    <ul class="plan-features">
                        @foreach($plan->features->where('pivot.value', '1')->take(6) as $feature)
                            <li><i class="fa fa-check"></i><span>{{ $feature->name }}</span></li>
                        @endforeach
                        @if($plan->max_course_access)
                            <li><i class="fa fa-check"></i><span>{{ $plan->max_course_access }} course access</span></li>
                        @else
                            <li><i class="fa fa-check"></i><span>Unlimited mapped course access</span></li>
                        @endif
                    </ul>

                    <form action="{{ route('subscription.add', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="edu-btn">
                            Add to Cart <i class="icon-4"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">No active subscription plans are available right now.</div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@if($subscriptions->isNotEmpty() && $features->isNotEmpty())
<section class="compare-section bg-light">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7">
                <span class="section-kicker">Compare</span>
                <h2 class="section-heading">Feature comparison</h2>
                <p class="section-copy">A clear view of which benefits are included in each plan.</p>
            </div>
        </div>

        <div class="compare-card">
            <div class="table-responsive">
                <table class="table comparison-table text-center">
                    <thead>
                        <tr>
                            <th class="text-start">Feature</th>
                            @foreach($subscriptions as $plan)
                                <th>{{ $plan->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-start">Price</th>
                            @foreach($subscriptions as $plan)
                                <td><strong>${{ number_format($plan->price, 2) }}</strong></td>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="text-start">Duration</th>
                            @foreach($subscriptions as $plan)
                                <td>{{ $plan->duration_days + $plan->free_extra_days }} days</td>
                            @endforeach
                        </tr>
                        @foreach($features as $feature)
                        <tr>
                            <th class="text-start">{{ $feature->name }}</th>
                            @foreach($subscriptions as $plan)
                                @php
                                    $planFeature = $plan->features->firstWhere('id', $feature->id);
                                    $enabled = $planFeature && $planFeature->pivot->value == '1';
                                @endphp
                                <td>
                                    <i class="fa {{ $enabled ? 'fa-check check-icon' : 'fa-minus dash-icon' }}"></i>
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endif

<section class="benefits-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7">
                <span class="section-kicker">Why Subscribe</span>
                <h2 class="section-heading">Built for repeat learning</h2>
                <p class="section-copy">A subscription keeps courses, compliance updates, and training resources easier to manage for individuals and teams.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="benefit-card">
                    <i class="icon-9"></i>
                    <h5>Centralized Access</h5>
                    <p>Keep live sessions, recordings, and eligible resources under one plan.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="benefit-card">
                    <i class="icon-13"></i>
                    <h5>Better Value</h5>
                    <p>Reduce one-off purchases when you need ongoing professional development.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="benefit-card">
                    <i class="icon-26"></i>
                    <h5>Flexible Learning</h5>
                    <p>Attend live when possible and use recordings or transcripts when available.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="benefit-card">
                    <i class="icon-45"></i>
                    <h5>Team Friendly</h5>
                    <p>Plans can be mapped by course or industry from the admin panel.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
