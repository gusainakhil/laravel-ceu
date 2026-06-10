@extends('layouts.app')

@section('title', 'Webinars | CEUTrainers')

@section('content')

<!-- BREADCRUMB START -->
<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Webinars</h1>
                <h3 class="title">Elevate your <span class="color-secondary">skills & expertise</span> with our webinars</h3>
                <span class="shape-line" style="color:#1AB69D"><i class="icon-19"></i></span>
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
<!-- BREADCRUMB END -->

<!-- SEARCH AND FILTERS START -->
<div class="container" style="background-color:#1AB69D; padding:30px 60px; border-radius: 5px; margin-top:60px; margin-bottom:-30px; position: relative; z-index: 10;">
    <form action="{{ route('webinar.index') }}" method="GET" id="filterForm">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <input type="search" placeholder="Search by title, instructor..." name="search" value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') { this.form.submit(); }" style="width: 100%; height: 50px; background-color: #fff;" />
            </div>

            <div class="col-xs-12 col-md-3">
                <div class="contact-form">
                    <div class="form-group col-12">
                        <select name="type" onchange="this.form.submit()" style="background-color:#fff; margin-bottom:5px;">
                            <option value="" {{ request('type') === null || request('type') === '' ? 'selected' : '' }}>Event</option>
                            <option value="live" {{ request('type') === 'live' ? 'selected' : '' }}>Live</option>
                            <option value="on_demand" {{ request('type') === 'on_demand' ? 'selected' : '' }}>Recorded</option>
                            <option value="packages" {{ request('type') === 'packages' ? 'selected' : '' }}>Packages</option>
                            <option value="long_hour" {{ request('type') === 'long_hour' ? 'selected' : '' }}>Long Hour Webinar</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-3">
                <div class="contact-form">
                    <div class="form-group col-12">
                        <select name="credit" onchange="this.form.submit()" style="background-color:#fff; margin-bottom:5px;">
                            <option value="" {{ request('credit') === null || request('credit') === '' ? 'selected' : '' }}>Credits</option>
                            <option value="HRCI" {{ request('credit') === 'HRCI' ? 'selected' : '' }}>HRCI</option>
                            <option value="SHRM" {{ request('credit') === 'SHRM' ? 'selected' : '' }}>SHRM</option>
                            <option value="CPE" {{ request('credit') === 'CPE' ? 'selected' : '' }}>CPE</option>
                            <option value="APA" {{ request('credit') === 'APA' ? 'selected' : '' }}>APA</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-3">
                <div class="contact-form">
                    <div class="form-group col-12">
                        <select name="industry" onchange="this.form.submit()" style="background-color:#fff; margin-bottom:5px;">
                            <option value="" {{ request('industry') === null || request('industry') === '' ? 'selected' : '' }}>Industry</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('industry') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- SEARCH AND FILTERS END -->

<!-- WEBINARS LIST START -->
<div class="edu-course-area course-area-1 gap-tb-text">
    <div class="container">
        @if($courses->isEmpty())
            <div class="text-center py-5 bg-white border border-light rounded-4 shadow-sm" style="border-radius: 10px; padding: 50px;">
                <i class="fa fa-book text-muted display-1 mb-3" style="font-size: 80px; color: #1ab69d !important;"></i>
                <h3 class="fw-bold mt-3">No Webinars Found</h3>
                <p class="text-slate max-w-400 mx-auto mt-2">We couldn't find any courses matching your specific search or filter criteria. Try resetting filters.</p>
                <a href="{{ route('webinar.index') }}" class="edu-btn mt-3" style="padding: 10px 25px;">Reset All Filters</a>
            </div>
        @else
            <div class="row g-5">
                @foreach($courses as $course)
                    @php
                        $day = $course->scheduled_at ? $course->scheduled_at->format('d') : '24';
                        $month = $course->scheduled_at ? $course->scheduled_at->format('M') : 'May';
                    @endphp
                    <div class="col-lg-4 col-md-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
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
                                        <img src="{{ $courseImg }}" alt="Course Meta">
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="event-date">
                                        <span class="day">{{ $day }}</span>
                                        <span class="month">{{ $month }}</span>
                                    </div>
                                    <div class="event-date" style="background-color:#1AB69D; top:-25px; left:20px; width:150px; height:50px; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size:medium; text-align:center; color:white; font-weight: bold; line-height: 1;">
                                            <i class="icon-33" style="color:white; margin-right: 5px;"></i>{{ $course->event_time ? \Carbon\Carbon::parse($course->event_time)->format('H:i') : '13:00' }} EST
                                        </span>
                                    </div>
                                    <h5 class="title">
                                        <a href="{{ route('course.show', $course->slug) }}">{{ $course->title }}</a>
                                    </h5>

                                    <p>
                                        <i class="fa fa-clock-o" style="font-size:16px; color:#1ab69d"></i>
                                        &nbsp;Duration: {{ $course->duration_mins }} Mins &nbsp;
                                        &nbsp;<span><i class="fa fa-volume-up" style="font-size:16px; color:#1ab69d"></i>
                                            {{ $course->speaker->user->name ?? ($course->speaker->name ?? 'Guest Expert') }}
                                        </span>
                                    </p>
                                    <div class="read-more-btn" style="display: flex; gap: 10px; margin-top: 20px;">
                                        <a class="edu-btn btn-small btn-secondary" href="{{ route('course.show', $course->slug) }}">Learn More <i class="icon-4"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($courses->hasPages())
                <div class="text-center" style="padding-top: 45px; color: #6f7f92; font-size: 15px;">
                    Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} results
                </div>
                <ul class="edu-pagination top-space-30">
                    @if($courses->onFirstPage())
                        <li class="disabled" aria-disabled="true">
                            <a href="javascript:void(0)" aria-label="Previous"><i class="icon-west"></i></a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $courses->previousPageUrl() }}" rel="prev" aria-label="Previous"><i class="icon-west"></i></a>
                        </li>
                    @endif

                    @for($page = 1; $page <= $courses->lastPage(); $page++)
                        @if($page === 1 || $page === $courses->lastPage() || abs($page - $courses->currentPage()) <= 1)
                            <li class="{{ $page === $courses->currentPage() ? 'active' : '' }}">
                                <a href="{{ $courses->url($page) }}" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                            </li>
                        @elseif($page === 2 || $page === $courses->lastPage() - 1)
                            <li class="more-next" aria-hidden="true">
                                <a href="javascript:void(0)"></a>
                            </li>
                        @endif
                    @endfor

                    @if($courses->hasMorePages())
                        <li>
                            <a href="{{ $courses->nextPageUrl() }}" rel="next" aria-label="Next"><i class="icon-east"></i></a>
                        </li>
                    @else
                        <li class="disabled" aria-disabled="true">
                            <a href="javascript:void(0)" aria-label="Next"><i class="icon-east"></i></a>
                        </li>
                    @endif
                </ul>
            @endif
        @endif
    </div>
</div>
<!-- WEBINARS LIST END -->

@endsection
