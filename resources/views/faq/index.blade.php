@extends('layouts.app')

@section('title', 'FAQs | CEUTrainers')

@section('styles')
<style>
    .faq-page-area .accordion-button {
        font-size: 20px !important;
        line-height: 1.45;
    }

    .faq-page-area .accordion-body,
    .faq-page-area .accordion-body p {
        font-size: 17px !important;
        line-height: 1.8;
    }

    .faq-support-card h4 {
        font-size: 24px;
    }

    .faq-support-card p,
    .faq-support-card span {
        font-size: 16px !important;
        line-height: 1.7;
    }

    @media (max-width: 767px) {
        .faq-page-area .accordion-button {
            font-size: 18px !important;
        }

        .faq-page-area .accordion-body,
        .faq-page-area .accordion-body p {
            font-size: 16px !important;
        }
    }
</style>
@endsection

@section('content')

<!-- BREADCRUMB START -->
<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Frequently <span class="color-secondary">Asked</span> Questions</h1>
                <span class="shape-line" style="text-align:left; color:#1AB69D"><i class="icon-19"></i></span>
            </div>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1"><span></span></li>
        <li class="shape-2 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape"></li>
        <li class="shape-3 scene"><img data-depth="-2" src="{{ asset('assets/images/about/shape-15.png') }}" alt="shape"></li>
        <li class="shape-4"><span></span></li>
        <li class="shape-5 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-07.png') }}" alt="shape"></li>
    </ul>
</div>
<!-- BREADCRUMB END -->

<!-- ACCORDIONS START -->
<section class="edu-section-gap faq-page-area" style="padding: 80px 0;">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-8">
                <div class="faq-accordion" id="faq-accordion-container">
                    <div class="accordion">
                        @foreach($faqs as $index => $faq)
                            <div class="accordion-item" style="border: 1px solid #f1f5f9; border-radius: 6px; margin-bottom: 15px; overflow: hidden;">
                                <h5 class="accordion-header" style="margin: 0;">
                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaq{{ $faq->id }}" 
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" style="font-weight: bold; font-family: var(--font-heading); font-size: 1.15rem; padding: 20px;">
                                        {{ $faq->question }}
                                    </button>
                                </h5>
                                <div id="collapseFaq{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                    data-bs-parent="#faq-accordion-container">
                                    <div class="accordion-body" style="padding: 20px; line-height: 1.7; color: #52525b; border-top: 1px solid #f1f5f9; background-color: #fafafa;">
                                        <p style="margin: 0;">{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="faq-support-card p-4 bg-white border border-light shadow-sm rounded-3" style="border-radius: 8px; border: 1px solid #f1f5f9 !important; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h4 class="fw-bold mb-3" style="color: #1ab69d; font-family: var(--font-heading);">Still Have Questions?</h4>
                    <p class="text-slate mb-4" style="color: #52525b; line-height: 1.6;">Our dedicated student advisory team is available to clarify certification regulations, accreditations, or technical access questions.</p>
                    
                    <div class="d-flex flex-column gap-3 mb-4" style="color: #1b1b1b;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa fa-phone" style="color: #1ab69d;"></i>
                            <span class="fw-semibold">(+1)-432-755-5553</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa fa-envelope" style="color: #1ab69d;"></i>
                            <span class="fw-semibold">support@ceutrainers.com</span>
                        </div>
                    </div>

                    <a href="{{ route('contact.index') }}" class="edu-btn text-center" style="width: 100%; font-weight: bold; background-color: #ee4a7f; border-color: #ee4a7f; color: white; padding: 12px 0;">
                        Open Help Ticket <i class="icon-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ACCORDIONS END -->

<!-- ACCREDITED CERTIFICATE START -->
<div class="edu-cta-banner-area home-one-cta-wrapper bg-image" style="margin-bottom: 50px;">
    <div class="container">
        <div class="edu-cta-banner">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <h2 class="title">Get Your Quality Skills <span class="color-secondary">Certificate</span> Through CEUTrainers</h2>
                        <a href="{{ route('contact.index') }}" class="edu-btn">Get started now <i class="icon-4"></i></a>
                    </div>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-01 scene"><img data-depth="2.5" src="{{ asset('assets/images/cta/shape-10.png') }}" alt="shape"></li>
                <li class="shape-02 scene"><img data-depth="-2.5" src="{{ asset('assets/images/cta/shape-09.png') }}" alt="shape"></li>
                <li class="shape-03 scene"><img data-depth="-2" src="{{ asset('assets/images/cta/shape-08.png') }}" alt="shape"></li>
                <li class="shape-04 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape"></li>
            </ul>
        </div>
    </div>
</div>
<!-- ACCREDITED CERTIFICATE END -->

@endsection
