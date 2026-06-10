@extends('layouts.app')

@section('title', $course->title . ' | CEUTrainers')

@section('styles')
<style type="text/css">
    .progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
    }

    .progress:before {
        content: "";
        position: absolute;
        bottom: 0;
        height: 100%;
        width: 100%;
        background-color: #2770ff;
    }

    .progress.active:before {
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        100% {
            width: 0%;
        }

        0% {
            width: 100%;
        }
    }

    .legend .row:nth-of-type(odd) div {
        background-color: #fff;
    }

    .legend .row:nth-of-type(even) div {
        background: #FFF;
    }

    .legend .row:hover div {
        background-color: #1AB39A;
    }

    .text {
        color: #808080;
    }

    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 250px;
        background-color: #C8F7EF;
        color: #fff;
        text-align: left;
        border-radius: 6px;
        padding: 2px 5px 5px 5px;
        top: 20px;
        right: 105%;
        font-size: xx-small;
        position: absolute;
        z-index: 1;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

    #clockdiv {
        color: #fff;
        display: inline-block;
        font-weight: 500;
        text-align: center;
        font-size: 15px;
        margin-bottom: 20px;
        margin-top: 50px;
    }

    #clockdiv>div {
        display: inline-block;
        padding: 12px 15px;
        margin-right: 5px;
        border: 3px solid #FB0351;
        border-radius: 50%;
        background-color: #ffffff;
    }

    #clockdiv div>span {
        display: inline-block;
        width: 55px;
        height: 35px;
        font-family: "Nunito", sans-serif;
        font-size: 30px;
        font-weight: bold;
        color: #0E1851;
    }

    .smalltext {
        padding-top: 0px;
        font-size: 12px;
        text-transform: uppercase;
        color: #0E1851;
        font-weight: bold;
    }

    .course-hero-meta {
        align-items: center;
        color: #52525b;
        display: flex;
        flex-wrap: nowrap;
        gap: 0;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .course-hero-meta li {
        align-items: center;
        color: #2f2f35;
        display: flex;
        font-family: var(--font-heading);
        font-size: 17px;
        font-weight: 500;
        line-height: 1.2;
        padding: 0 14px;
        white-space: nowrap;
    }

    .course-hero-meta li + li {
        border-left: 1px solid #d6d6d6;
    }

    .course-hero-meta i {
        color: #1ab69d;
        font-size: 26px;
        margin-right: 10px;
    }

    .course-hero-time {
        align-items: center;
        color: #2f2f35;
        display: flex;
        font-family: var(--font-heading);
        font-size: 16px;
        font-weight: 500;
        justify-content: center;
        line-height: 1.25;
        list-style: none;
        margin: 28px 0 0;
        padding: 0;
        text-align: center;
    }

    .course-hero-time i {
        color: #1ab69d;
        font-size: 30px;
        margin-right: 12px;
    }

    .course-hero-time strong {
        color: #2f2f35;
        font-size: inherit;
        font-weight: 500;
    }

    /* Custom accordion styling for FAQs tab */
    .faq-accordion .accordion-item {
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        margin-bottom: 12px;
        overflow: hidden;
    }
    .faq-accordion .accordion-button {
        font-weight: bold;
        color: #1b1b1b;
        background-color: #ffffff;
        padding: 15px 20px;
        border: none;
        outline: none;
        box-shadow: none;
    }
    .faq-accordion .accordion-button:not(.collapsed) {
        color: #1ab69d;
        background-color: #f0fbf9;
    }
    .faq-accordion .accordion-body {
        padding: 20px;
        background-color: #ffffff;
        color: #52525b;
        line-height: 1.7;
    }

    .registration-sidebar {
        position: sticky;
        top: 100px;
        z-index: 10;
    }

    .registration-card {
        background: #ffffff;
        border: 1px solid #f1f1f1;
        border-radius: 4px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .registration-card__title {
        color: #1ab69d;
        font-family: var(--font-heading);
        font-size: 28px !important;
        font-weight: 800 !important;
        line-height: 1.2 !important;
        margin: 0;
        padding: 18px 18px 8px;
        text-align: center;
    }

    .registration-card__title span {
        border-bottom: 2px solid #1ab69d;
        display: inline-block;
        padding-bottom: 8px;
    }

    .registration-card__body {
        border-top: 1px solid #eeeeee;
        padding: 24px 26px 26px;
    }

    .registration-group {
        border-top: 1px solid #eeeeee;
        padding-top: 20px;
    }

    .registration-group:first-child {
        border-top: 0;
        padding-top: 0;
    }

    .registration-group + .registration-group {
        margin-top: 18px;
    }

    .registration-group__title {
        color: #000000;
        font-size: 26px !important;
        font-weight: 800 !important;
        line-height: 1.35 !important;
        margin: 0 0 20px;
        text-align: center;
        text-transform: capitalize;
    }

    .registration-options {
        border-top: 1px solid #eeeeee;
        padding-top: 14px;
    }

    .registration-option {
        align-items: flex-start;
        display: grid;
        column-gap: 14px;
        grid-template-columns: 22px minmax(0, 1fr) 74px;
        margin: 0;
        padding: 6px 8px;
    }

    .registration-option + .registration-option {
        margin-top: 7px;
    }

    .registration-option input {
        -webkit-appearance: none;
        appearance: none;
        background: #ffffff;
        border: 1px solid #cfd4d8;
        border-radius: 2px;
        cursor: pointer;
        height: 16px;
        margin: 2px 0 0;
        opacity: 1 !important;
        position: static !important;
        width: 16px;
    }

    .registration-option input:focus-visible {
        outline: 2px solid rgba(26, 182, 157, 0.35);
        outline-offset: 2px;
    }

    .registration-option input:checked {
        background: #1ab69d;
        border-color: #1ab69d;
        box-shadow: inset 0 0 0 4px #ffffff;
    }

    .registration-option label {
        color: #202124;
        cursor: pointer;
        display: block;
        font-size: 18px !important;
        font-weight: 400;
        line-height: 1.28 !important;
        margin: 0;
        max-width: none;
        overflow-wrap: normal;
        padding-left: 0 !important;
        position: static !important;
        user-select: none;
        white-space: normal;
        word-break: normal;
    }

    .registration-option label::before,
    .registration-option label::after {
        display: none !important;
    }

    .registration-option__main {
        display: inline-block;
        white-space: nowrap;
    }

    .registration-option__detail {
        display: inline;
    }

    .registration-option__price {
        color: #fb064f;
        font-size: 18px !important;
        font-weight: 800 !important;
        line-height: 1.28 !important;
        padding-left: 0;
        text-align: right;
        white-space: nowrap;
    }

    .registration-help {
        border-top: 1px solid #eeeeee;
        color: #000000;
        font-size: 15px;
        line-height: 1.6;
        margin: 24px 0 0;
        padding-top: 20px;
    }

    .registration-total {
        border-top: 1px solid #eeeeee;
        color: #1ab69d;
        font-size: 26px;
        font-weight: 800;
        margin: 20px 0;
        padding-top: 20px;
        text-align: center;
    }

    @media (max-width: 1199px) {
        .registration-card__body {
            padding: 22px 20px 24px;
        }

        .registration-group__title {
            font-size: 24px !important;
        }

        .registration-option label,
        .registration-option__price {
            font-size: 16px !important;
        }
    }

    @media (max-width: 991px) {
        .registration-sidebar {
            margin-top: 40px;
            position: static;
        }

        .course-hero-meta li {
            font-size: 16px;
            padding: 0 10px;
        }

        .course-hero-meta i {
            font-size: 24px;
            margin-right: 8px;
        }

        .course-hero-time {
            font-size: 15px;
        }

        .course-hero-time i {
            font-size: 26px;
            margin-right: 10px;
        }
    }

    @media (max-width: 575px) {
        .course-hero-meta {
            align-items: flex-start;
            flex-direction: column;
            gap: 14px;
        }

        .course-hero-meta li {
            border-left: 0 !important;
            font-size: 16px;
            padding: 0;
        }

        .course-hero-meta i {
            font-size: 24px;
            min-width: 30px;
        }

        .course-hero-time {
            font-size: 15px;
            justify-content: flex-start;
            text-align: left;
        }

        .course-hero-time i {
            font-size: 26px;
            min-width: 30px;
        }

        .registration-card__title {
            font-size: 23px !important;
            padding-left: 16px;
            padding-right: 16px;
        }

        .registration-card__body {
            padding: 22px 16px 24px;
        }

        .registration-option {
            gap: 10px;
            grid-template-columns: 20px minmax(0, 1fr) 64px;
            padding-left: 0;
            padding-right: 0;
        }

        .registration-option label,
        .registration-option__price {
            font-size: 15px !important;
        }
    }
</style>
@endsection

@section('content')

@php
    $datetime = $course->scheduled_at ? $course->scheduled_at->format('Y-m-d H:i:s') : '2026-06-17 13:00:00';
    try {
        $inputTimezone = new \DateTimeZone('America/New_York');
        $inputDatetime = new \DateTime($datetime, $inputTimezone);
        
        $inputDatetime->setTimezone($inputTimezone);
        $est = $inputDatetime->format('h:i:s A');

        $cstTimezone = new \DateTimeZone('America/Chicago');
        $inputDatetime->setTimezone($cstTimezone);
        $cst = $inputDatetime->format('h:i:s A');

        $mstTimezone = new \DateTimeZone('America/Denver');
        $inputDatetime->setTimezone($mstTimezone);
        $mst = $inputDatetime->format('h:i:s A');

        $pstTimezone = new \DateTimeZone('America/Los_Angeles');
        $inputDatetime->setTimezone($pstTimezone);
        $pst = $inputDatetime->format('h:i:s A');

        $formattedTimezones = $est." (EST) | ". $cst." (CST) | ". $mst." (MST) | " . $pst." (PST)";
    } catch (\Exception $e) {
        $formattedTimezones = "01:00:00 PM (EST) | 12:00:00 PM (CST) | 11:00:00 AM (MST) | 10:00:00 AM (PST)";
    }
@endphp

<div class="online-academy-cta-wrapper edu-cta-banner-area bg-image">
    <div class="container">
        <div class="edu-cta-banner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-breadcrumb-area" style="background-color: transparent; padding: 15px 0 15px;">
                            <h2 class="title" style="color: #18181b;">{{ $course->title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-breadcrumb-area" style="background-color: transparent; padding: 15px 0 15px;">
                            <div class="breadcrumb-inner">
                                <ul class="course-hero-meta">
                                    <li><i class="icon-58"></i> <span>{{ $course->speaker->user->name ?? $course->speaker->name }}</span></li>
                                    <li><i class="fa fa-hourglass-start"></i> <span>{{ $course->duration_mins }} minutes</span></li>
                                    <li><i class="fa fa-calendar"></i> <span>{{ $course->scheduled_at ? $course->scheduled_at->format('F d, Y') : 'June 17, 2026' }}</span></li>
                                </ul>
                                <ul class="course-hero-time">
                                    <li class="d-flex align-items-center"><i class="icon-61"></i> <span>{{ $formattedTimezones }}</span></li>
                                </ul>

                                <div id="clockdiv">
                                    <div>
                                        <span class="days" id="days"></span>
                                        <div class="smalltext">Days</div>
                                    </div>
                                    <div>
                                        <span class="hours" id="hours"></span>
                                        <div class="smalltext">Hours</div>
                                    </div>
                                    <div>
                                        <span class="minutes" id="minutes"></span>
                                        <div class="smalltext">Mins</div>
                                    </div>
                                    <div>
                                        <span class="seconds" id="seconds"></span>
                                        <div class="smalltext">Secs</div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="edu-btn"></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="course-sidebar-3 sidebar-top-position">
                        <div class="edu-course-widget widget-course-summery">
                            <div class="inner">
                                <div class="thumbnail">
                                    @php
                                        $courseImg = $course->thumbnail;
                                        if (!$courseImg) {
                                            $courseImg = asset('ceuadmin-assets/assets/images/course/ceutrainers.webp');
                                        } else {
                                            $courseImg = str_starts_with($courseImg, 'http') ? $courseImg : asset('ceuadmin-assets/assets/images/course/' . $courseImg);
                                        }
                                    @endphp
                                    <img src="{{ $courseImg }}" alt="Courses">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <ul class="shape-group">
                    <li class="shape-01 scene">
                        <img data-depth="2.5" src="{{ asset('assets/images/cta/shape-10.png') }}" alt="shape">
                    </li>
                    <li class="shape-02 scene">
                        <img data-depth="-2.5" src="{{ asset('assets/images/cta/shape-09.png') }}" alt="shape">
                    </li>
                    <li class="shape-03 scene">
                        <img data-depth="-2" src="{{ asset('assets/images/cta/shape-08.png') }}" alt="shape">
                    </li>
                    <li class="shape-04 scene">
                        <img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="edu-section-gap course-details-area">
    <div class="container">
        <div class="row row--30">
            <!-- Left Tabs Panel -->
            <div class="col-lg-7">
                <div class="course-details-content">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor" type="button" role="tab" aria-controls="instructor" aria-selected="false">Speaker</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="carriculam-tab" data-bs-toggle="tab" data-bs-target="#carriculam" type="button" role="tab" aria-controls="carriculam" aria-selected="false">Credits</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">FAQs</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="course-tab-content" style="text-align: justify; text-justify: inter-word; color: black; font-size: 1.05rem; line-height: 1.8;">
                                <!-- <p style="font-style: italic; font-weight: bold; margin-bottom: 25px;">
                                    SHRM & HRCI Approved Webinar | CEUs = 1.5 Credit Hours
                                </p> -->
                                <!-- <h3 class="fw-800 text-dark mb-3" style="font-size: 1.5rem;">Overview:</h3> -->
                                <p>{!! $course->description !!}</p>
                            </div>
                        </div>

                        <!-- Speaker Tab -->
                        <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                            <div class="course-tab-content">
                                <div class="course-instructor d-flex gap-4 flex-wrap align-items-start">
                                    <div class="thumbnail" style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.06); border: 3px solid #ffffff; float: left; margin-right: 20px;">
                                        @php
                                            $speakerImg = $course->speaker->image ?? null;
                                            if (!$speakerImg) {
                                                $speakerImg = asset('ceuadmin-assets/assets/images/profile_av.svg');
                                            } elseif (!str_starts_with($speakerImg, 'http')) {
                                                $speakerImg = asset('ceuadmin-assets/assets/images/speaker/' . $speakerImg);
                                            }
                                        @endphp
                                        <img src="{{ $speakerImg }}" alt="{{ $course->speaker->user->name ?? $course->speaker->name }}" style="width: 100%; height: 100%; object-fit: cover;" />
                                    </div>
                                    <div class="author-content" style="flex: 1; min-width: 250px;">
                                        <h4 class="title fw-800 text-dark mb-1" style="font-size: 1.5rem; margin-top: 0;">{{ $course->speaker->user->name ?? $course->speaker->name }}</h4>
                                        <span class="subtitle fw-bold display-block mb-3" style="color: #1ab69d; font-size: 1rem;">{{ $course->speaker->designation }}</span>
                                        <div style="text-align: justify; color: #52525b; line-height: 1.7; font-size: 0.95rem;">{!! $course->speaker->bio !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Credits Tab -->
                        <div class="tab-pane fade" id="carriculam" role="tabpanel" aria-labelledby="carriculam-tab">
                            <div class="course-tab-content">
                                <div class="course-curriculam" style="color: #1b1b1b; line-height: 1.8; font-size: 1.05rem;">
                                    <h5 class="fw-800 mb-3" style="color: #1ab69d !important;">Continuing Education Accreditations</h5>
                                    {!! $course->certificate_text ?: '<p>Upon successful completion of this training program, attendees will receive a verified accredited CEU completion certificate. This program qualifies for professional CEU credits under licensed standard compliance regulations (including HRCI recertification credits, SHRM professional development credits, and general corporate licensing metrics).</p>' !!}
                                </div>
                            </div>
                        </div>

                        <!-- FAQs Tab -->
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <div class="course-tab-content faq-accordion">
                                <div class="accordion" id="faqAccordion">
                                    @forelse($faqs as $faqIndex => $faq)
                                        @php
                                            $headingId = 'faqHeading' . $faq->id;
                                            $collapseId = 'faqCollapse' . $faq->id;
                                        @endphp
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="{{ $headingId }}">
                                                <button class="accordion-button {{ $faqIndex === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $faqIndex === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                                    {{ $faq->question }}
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $faqIndex === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    {!! $faq->answer !!}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    How do I receive my CEU Completion Certificate?
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Immediately after the course finishes, you can claim your certificate from your student dashboard, or check your registered email address for a secure PDF copy.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    What if I register for the Live Webinar but miss the session?
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Don't worry! If you miss the live broadcast, contact our live support or payroll team, and we will immediately provide you with access to the On-Demand recording at no extra fee.
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side Pricing Column -->
            <div class="col-lg-5">
                <div class="registration-sidebar">
                    <div class="registration-card">
                        <h3 class="registration-card__title"><span>Registration Options</span></h3>

                        <div class="registration-card__body">
                            @php
                                $a = 0;
                                $data = $groupedOptions;
                            @endphp
                            @foreach ($data as $key => $innerArray)
                                @php
                                    $a++;
                                    $registrationGroupTitles = [
                                        'live' => 'Live Options',
                                        'recording' => 'Recording & Combos',
                                        'recording / on-demand' => 'Recording & Combos',
                                        'super_saver' => 'Super Saver Options (Get On-Demands & e-Transcripts FREE)',
                                        'super saver' => 'Super Saver Options (Get On-Demands & e-Transcripts FREE)',
                                    ];
                                    $normalizedGroupKey = strtolower(str_replace(['-', '_'], ' ', trim($key)));
                                    $groupTitle = $registrationGroupTitles[$normalizedGroupKey] ?? $key;
                                @endphp
                                <section class="registration-group">
                                    <h3 class="registration-group__title">{{ $groupTitle }}</h3>
                                    <div class="registration-options">
                                        @foreach ($innerArray as $name => $amount)
                                            @php 
                                                $a++;
                                                $optionMainText = $name;
                                                $optionDetailText = '';
                                                if (preg_match('/^(\d+\s+Attendees?)(.*)$/i', $name, $matches)) {
                                                    $optionMainText = trim($matches[1]);
                                                    $optionDetailText = trim($matches[2]);
                                                }
                                            @endphp
                                            <div class="registration-option">
                                                <input type="checkbox" id="cat-check{{ $a }}" class="parentSpace" data-cname="{{ $name }}" data-amount="{{ $amount }}">
                                                <label for="cat-check{{ $a }}">
                                                    <span class="registration-option__main">{{ $optionMainText }}</span>
                                                    @if ($optionDetailText)
                                                        <span class="registration-option__detail"> {{ $optionDetailText }}</span>
                                                    @endif
                                                </label>
                                                <span class="registration-option__price">${{ $amount }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endforeach

                            <div id="all-inputs-container"></div>

                            <p class="registration-help">
                                <i class="fa fa-asterisk" style="font-size:15px; color: #1ab69d;"></i> Couldn't find the option you're looking for? Don't worry, let us know your requirements and we will get back to you SOON!
                                <a style="color:#1AB39A;" href="{{ route('contact.index') }}"><u><b> Contact Us Now</b></u></a>
                            </p>

                            <h4 class="registration-total" id="output">Total Fee: $0.00</h4>

                            <form method="post" action="{{ route('cart.add', $course->id) }}" id="cartForm">
                                @csrf
                                <input type="hidden" name="array" id="array" required>
                                <div class="read-more-btn">
                                    <button type="submit" class="edu-btn" style="font-size:x-large; font-weight:bold; width: 100%; border: none; background-color: #1ab69d;">Add To Cart <i class="icon-4"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Countdown Timer logic matching original ceuservices script
    var x = setInterval(function() {
        var eventDateStr = "{{ $course->scheduled_at ? $course->scheduled_at->format('Y/m/d H:i:s') : '2026/06/17 13:00:00' }}";
        var countDownDate = new Date(eventDateStr).getTime();
        var now = new Date().getTime();
        var distance = countDownDate - now;
        
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("days").innerHTML = days > 0 ? days : 0;
        document.getElementById("hours").innerHTML = hours > 0 ? hours : 0;
        document.getElementById("minutes").innerHTML = minutes > 0 ? minutes : 0;
        document.getElementById("seconds").innerHTML = seconds > 0 ? seconds : 0;
        
        if (distance < 0) {
            clearInterval(x);
        }
    }, 1000);

    // Bootstrap Tab initialization
    document.querySelectorAll('#myTab button').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var tabTrigger = new bootstrap.Tab(this);
            tabTrigger.show();
        });
    });

    $(document).ready(function() {
        var dataArray = [];

        // Update total fee calculation when a checkbox changes state
        $('.parentSpace').on('change', function() {
            updateOutput();
        });

        function updateOutput() {
            dataArray = [];
            var totalAmount = 0;

            $('.parentSpace:checked').each(function() {
                var amount = parseFloat($(this).data('amount'));
                var cname = $(this).data('cname');
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
                dataArray.push("'" + cname + "'=>'" + amount + "'");
            });

            var arrayString = 'array(' + dataArray.join(',') + ')';
            $('#output').text('Total Fee: $' + totalAmount.toFixed(2));
            $('#array').val(dataArray.length > 0 ? arrayString : '');
        }

        // Form submission check
        $('#cartForm').on('submit', function(e) {
            var arrayVal = $('#array').val();
            if (!arrayVal || arrayVal.trim() === '' || arrayVal === 'array()') {
                e.preventDefault();
                alert("Please select at least one registration option.");
            }
        });
    });
</script>
@endsection
