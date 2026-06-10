@extends('layouts.app')

@section('title', 'CEU Trainers | Online Education Platform')

@section('styles')
<style>
    .cta-area-1 .edu-cta-box.cta-style-3 .inner .content .title a {
        font-size: 21px !important;
        white-space: nowrap !important;
        letter-spacing: -0.5px;
    }
    
    @media (max-width: 1199px) {
        .cta-area-1 .edu-cta-box.cta-style-3 .inner .content .title a {
            font-size: 18px !important;
        }
    }
    
    @media (max-width: 991px) {
        .cta-area-1 {
            width: 90% !important;
        }
        .cta-area-1 .edu-cta-box.cta-style-3 .inner .content .title a {
            font-size: 16px !important;
        }
    }
    
    @media (max-width: 767px) {
        .cta-area-1 .edu-cta-box.cta-style-3 .inner {
            flex-direction: column;
            gap: 15px;
            text-align: center !important;
        }
        .cta-area-1 .edu-cta-box.cta-style-3 .inner .content {
            text-align: center !important;
        }
        .cta-area-1 .edu-cta-box.cta-style-3 .inner .sparator {
            margin: 5px auto !important;
        }
    }
</style>
@endsection

@section('content')

<!-- HERO BANNER START -->
<div class="hero-banner hero-style-4 bg-image">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="banner-content">
                    <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">Learn Without Limits</h1>
                    <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">Start, switch, or advance your career with more than 5,800 courses, Professional Certificates, and degrees from world-class universities and companies.</p>
                    <div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                        <a href="{{ route('webinar.index') }}" class="edu-btn">Browse <i class="icon-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-gallery">
        <div class="thumbnail thumbnail-1" data-sal-delay="500" data-sal="slide-up" data-sal-duration="1000">
            <img src="{{ asset('assets/HeroImages/hero01.png') }}" alt="Girl Image">
        </div>
        <div class="thumbnail thumbnail-2" data-sal-delay="500" data-sal="slide-down" data-sal-duration="1000">
            <img src="{{ asset('assets/HeroImages/hero02.png') }}" alt="Girl Image">
        </div>
        <div class="thumbnail thumbnail-3" data-sal-delay="500" data-sal="slide-right" data-sal-duration="1000">
            <img src="{{ asset('assets/HeroImages/hero03.png') }}" alt="Girl Image">
        </div>
        <div class="online-support" data-sal-delay="600" data-sal="slide-right" data-sal-duration="1000">
            <div class="inner">
                <div class="icon"> 
                    <i class="icon-29"></i>
                </div>
                <div class="content">
                    <span class="subtitle">Live Support</span>
                    <h4 class="title"><a href="tel:(702)-605-0095">(702)-605-0095</a></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-down-btn">
        <a class="scroll-btn" href="#categories"><i class="icon-41"></i></a>
    </div>
    <ul class="shape-group">
        <li class="shape-1 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="2" src="{{ asset('assets/images/others/shape-17.png') }}" alt="Shape">
        </li>
        <li class="shape-2 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="-2" src="{{ asset('assets/images/banner/shape-03.png') }}" alt="Shape">
        </li>
        <li class="shape-3 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="2" src="{{ asset('assets/images/faq/shape-09.png') }}" alt="Shape">
        </li>
        <li class="shape-4 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="-2" src="{{ asset('assets/images/others/shape-15.png') }}" alt="Shape">
        </li>
        <li class="shape-5 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="-2" src="{{ asset('assets/images/others/shape-16.png') }}" alt="Shape">
        </li>
        <li class="shape-6 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="2" src="{{ asset('assets/images/faq/shape-12.png') }}" alt="Shape">
        </li>
        <li class="shape-7 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="-2" src="{{ asset('assets/images/others/shape-17.png') }}" alt="Shape">
        </li>
        <li class="shape-8 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <span></span>
        </li>
    </ul>
</div>
<!-- HERO BANNER END -->

<!-- CATEGORIES GRID START -->
<div class="edu-categorie-area categorie-area-3 edu-section-gap bg-image" id="categories">
    <div class="container">
        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
            <span class="pre-title pre-textsecondary">Categories</span>
            <h2 class="title">Online <span class="color-primary">Classes</span> For Remote Learning.</h2>
            <span class="shape-line"><i class="icon-19"></i></span>
        </div>
        <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
            @foreach($categories as $category)
                <div class="col-lg-3" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                    <div class="categorie-grid categorie-style-3 color-primary-style">
                        <a href="{{ route('webinar.index', ['industry' => $category->id]) }}">
                            @php
                                $imgSrc = $category->image ?: 'laptop.svg';
                                if (!str_starts_with($imgSrc, 'http')) {
                                    $imgSrc = asset('assets/images/category/' . $imgSrc);
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" width="100%" alt="{{ $category->name }}" />
                        </a>
                        <div class="content">
                            <h5 class="title">{{ $category->name }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- CATEGORIES GRID END -->

<!-- CLIENT LOGOS START -->
<div class="edu-brand-area brand-area-1 gap-top-equal">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="brand-section-heading">
                    <div class="section-title section-left" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <span class="pre-title">Our Happy Clients</span>
                        <h2 class="title">Learn with professionals from Leading companies and corporations</h2>
                        <span class="shape-line"><i class="icon-19"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="brand-grid-wrap">
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-01.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-02.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-03.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-04.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-05.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-06.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-07.jpg') }}" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="{{ asset('assets/Brands/client-logo-08.jpg') }}" alt="Brand Logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CLIENT LOGOS END -->

<!-- SPEAKERS TEAM START -->
<div class="edu-team-area team-area-2 edu-section-gap">
    <div class="container">
        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
            <span class="pre-title">Our Speakers</span>
            <h2 class="title">Top Speakers</h2>
            <span class="shape-line"><i class="icon-19"></i></span>
        </div>
        <div class="row g-5">
            @foreach($speakers->take(4) as $speaker)
                <div class="col-lg-3 col-md-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <a class="edu-team-grid team-style-2 d-block" href="{{ route('speakers.show', $speaker) }}">
                        <div class="inner">
                            <div class="thumbnail-wrap">
                                <div class="thumbnail">
                                    @php
                                        $speakerImg = $speaker->image;
                                        if (!$speakerImg) {
                                            $speakerImg = asset('ceuadmin-assets/assets/images/profile_av.svg');
                                        } elseif (!str_starts_with($speakerImg, 'http')) {
                                            $speakerImg = asset('ceuadmin-assets/assets/images/speaker/' . $speakerImg);
                                        }
                                    @endphp
                                    <img src="{{ $speakerImg }}" alt="{{ $speaker->name }}" />
                                </div>
                            </div>
                            <div class="content">
                                <h5 class="title">{{ $speaker->name }}</h5>
                                <span class="designation">{{ $speaker->designation }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- SPEAKERS TEAM END -->

<!-- BECOME SPEAKER BANNER START -->
<div class="online-academy-cta-wrapper edu-cta-banner-area bg-image">
    <div class="container">
        <div class="edu-cta-banner">
            <div class="row justify-content-center" style="height: 400px;">
                <div class="col-lg-7">
                    <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <h2 style="margin-top: 100px;" class="title">Become A Speaker at <span class="color-secondary">CEUTrainers</span></h2>
                        <p>Top Industry experts teach numerous professionals on CEU Trainers.</p>
                        <a href="{{ route('speakers.become') }}" class="edu-btn">Start Teaching <i class="icon-4"></i></a>
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
<br /><br /><br />
<!-- BECOME SPEAKER BANNER END -->

<!-- ODOMETER COUNTERS START -->
<div class="counterup-area-3 gap-bottom-equal">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3 col-sm-6">
                <div class="edu-counterup counterup-style-3">
                    <h2 class="counter-item count-number primary-color">
                        <span class="odometer" data-odometer-final="15400">.</span>
                    </h2>
                    <h6 class="title">Student Enrolled</h6>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="edu-counterup counterup-style-3">
                    <h2 class="counter-item count-number secondary-color">
                        <span class="odometer" data-odometer-final="580">.</span>
                    </h2>
                    <h6 class="title">Webinars Completed</h6>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="edu-counterup counterup-style-3">
                    <h2 class="counter-item count-number extra02-color">
                        <span class="odometer" data-odometer-final="99">.</span><span>%</span>
                    </h2>
                    <h6 class="title">Satisfaction Rate</h6>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="edu-counterup counterup-style-3 border-none">
                    <h2 class="counter-item count-number extra05-color">
                        <span class="odometer" data-odometer-final="25">.</span><span>+</span>
                    </h2>
                    <h6 class="title">Top Speakers</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ODOMETER COUNTERS END -->

<!-- FAQ ACCORDION START -->
<div class="edu-faq-area faq-style-2 bg-image">
    <div class="container">
        <div class="row g-5 row--45">
            <div class="col-lg-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="1000">
                <div class="edu-faq-content">
                    <div class="section-title section-left">
                        <span class="pre-title">FAq’s</span>
                        <h2 class="title">Learn Best Education Culture with CEUTrainers</h2>
                        <span class="shape-line"><i class="icon-19"></i></span>
                    </div>
                    <div class="faq-accordion" id="faq-accordion">
                        <div class="accordion">
                            @foreach($faqs as $index => $faq)
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $faq->id }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h5>
                                    <div id="collapseOne{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                        data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>{{ $faq->answer }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="edu-faq-gallery">
                    <div class="row g-5">
                        <div class="col-6" data-sal-delay="50" data-sal="slide-down" data-sal-duration="1000">
                            <div class="faq-thumbnail thumbnail-1">
                                <img src="{{ asset('assets/FaQ/faq01.png') }}" alt="Faq Images">
                            </div>
                        </div>
                        <div class="col-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="1000">
                            <div class="faq-thumbnail thumbnail-2">
                                <img src="{{ asset('assets/FaQ/faq02.png') }}" alt="Faq Images">
                            </div>
                        </div>
                    </div>
                    <ul class="shape-group">
                        <li class="shape-1 scene">
                            <img data-depth="2" src="{{ asset('assets/images/faq/shape-06.png') }}" alt="Shape Images">
                        </li>
                        <li class="shape-2">
                            <img data-depth="-2" src="{{ asset('assets/images/faq/shape-04.png') }}" alt="Shape Images">
                        </li>
                        <li class="shape-3 scene">
                            <img data-depth="2" src="{{ asset('assets/images/faq/shape-16.png') }}" alt="Shape Images">
                        </li>
                        <li class="shape-4 scene">
                            <img data-depth="-2" src="{{ asset('assets/images/banner/shape-03.png') }}" alt="Shape Images">
                        </li>
                        <li class="shape-5 scene">
                            <img data-depth="-2" src="{{ asset('assets/images/faq/shape-08.png') }}" alt="Shape Images">
                        </li>
                        <li class="shape-6 scene">
                            <img data-depth="1.7" src="{{ asset('assets/images/faq/shape-09.png') }}" alt="Shape Images">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQ ACCORDION END -->

<!-- EVENTS & WEBINARS START -->
<div class="edu-event-area event-area-2">
    <div class="container edublink-animated-shape">
        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
            <span class="pre-title">Events & News</span>
            <h2 class="title">Popular Events & News</h2>
            <span class="shape-line"><i class="icon-19"></i></span>
        </div>
        <div class="row g-5">
            @foreach($courses->take(3) as $course)
                @php
                    $day = $course->scheduled_at ? $course->scheduled_at->format('d') : '24';
                    $month = $course->scheduled_at ? $course->scheduled_at->format('M') : 'May';
                @endphp
                <div class="col-lg-4 col-md-6" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                    <div class="edu-event event-style-1">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="{{ route('course.show', $course->slug) }}">
                                    @php
                                        $courseImg = $course->thumbnail;
                                        if (!$courseImg) {
                                            $courseImg = asset('ceuadmin-assets/assets/images/course/ceutrainers.webp');
                                        } else {
                                            $courseImg = str_starts_with($courseImg, 'http') ? $courseImg : asset('ceuadmin-assets/assets/images/course/' . $courseImg);
                                        }
                                    @endphp
                                    <img src="{{ $courseImg }}" alt="Course Images">
                                </a>
                                <div class="event-time">
                                    <span><i class="icon-33"></i>{{ $course->event_time ? \Carbon\Carbon::parse($course->event_time)->format('H:i') : '13:00' }} EST</span>
                                </div>
                            </div>
                            <div class="content">
                                <div class="event-date">
                                    <span class="day">{{ $day }}</span>
                                    <span class="month">{{ $month }}</span>
                                </div>
                                <h5 class="title"><a href="{{ route('course.show', $course->slug) }}">{{ $course->category->name ?? 'Compliance' }}</a></h5>
                                <h5 class="title"><a href="{{ route('course.show', $course->slug) }}">{{ $course->title }}</a></h5>
                                <p>
                                    <i class="fa fa-clock-o" style="font-size:16px;color:#1ab69d"></i> &nbsp;Duration: {{ $course->duration_mins }}&nbsp;Mins  &nbsp;
                                    &nbsp;<span><i class="fa fa-volume-up" style="font-size:16px;color:#1ab69d"></i> {{ $course->speaker->user->name ?? ($course->speaker->name ?? 'Guest Expert') }}</span> 
                                </p>
                                <div class="read-more-btn" style="display: flex; gap: 10px; margin-top: 15px;">
                                    <a class="edu-btn btn-small btn-secondary" href="{{ route('course.show', $course->slug) }}">Learn More <i class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <ul class="shape-group">
            <li class="shape-1" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                <img class="rotateit" src="{{ asset('assets/images/about/shape-13.png') }}" alt="Shape">
            </li>
            <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                <span data-depth=".9"></span>
            </li>
        </ul>
    </div>
</div>
<!-- EVENTS & WEBINARS END -->

<!-- ACCREDITED CERTIFICATE START -->
<div class="online-academy-cta-wrapper edu-cta-banner-area bg-image">
    <div class="container">
        <div class="edu-cta-banner">
            <div class="row justify-content-center" style="height: 400px;">
                <div class="col-lg-7">
                    <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <h2 style="margin-top:100px;" class="title">Get Your Quality Skills <span class="color-secondary">Certificate</span> Through CEUTrainers</h2>
                        <a href="{{ route('contact.index') }}" class="edu-btn">Get started now <i class="icon-4"></i></a>
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
<!-- ACCREDITED CERTIFICATE END -->

<div style="min-height:50px; width:100%"></div>

<!-- TESTIMONIALS COVERFLOW SLIDER START -->
<div class="testimonial-area-5 gap-lg-bottom-equal">
    <div class="container">
        <div class="row g-lg-5">
            <div class="col-lg-5">
                <div class="testimonial-heading-area">
                    <div class="section-title section-left" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <span class="pre-title">Testimonials</span>
                        <h2 class="title">What Our Attendees Have To Say</h2>
                        <span class="shape-line"><i class="icon-19"></i></span>
                        <p>One-stop solution for all online courses. People love CEUTrainers because they can learn about the latest developments in their fields.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="swiper-testimonial-slider-wrapper swiper testimonial-coverflow">
                    <div class="swiper-wrapper">
                        @foreach($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="testimonial-grid">
                                    <div class="content">
                                        <p>{{ $testimonial->message }}</p>
                                        <div class="rating-icon">
                                            @for($rating = 0; $rating < ($testimonial->rating ?: 5); $rating++)
                                                <i class="icon-23"></i>
                                            @endfor
                                        </div>
                                        <h5 class="title">{{ $testimonial->name }}</h5>
                                        <span class="subtitle">{{ $testimonial->designation }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- TESTIMONIALS COVERFLOW SLIDER END -->

<!-- GET IN TOUCH CALL OUT START -->
<div class="cta-area-1" style="width: 75%; margin: 0 auto; border-radius: 30px; margin-bottom: -6em; position: relative;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="home-four-cta edu-cta-box cta-style-3 bg-image bg-image--16" style="z-index: 9;">
                    <div class="inner">
                        <div class="content text-end">
                            <span class="subtitle">Get In Touch:</span>
                            <h3 class="title"><a href="mailto:info@ceutrainers.com">info@ceutrainers.com</a></h3>
                        </div>
                        <div class="sparator">
                            <span>or</span>
                        </div>
                        <div class="content">
                            <span class="subtitle">Call Us Via:</span>
                            <h3 class="title"><a href="tel:(+1)-432-755-5553">(+1)-432-755-5553</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- GET IN TOUCH CALL OUT END -->

@endsection
