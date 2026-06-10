@extends('layouts.app')

@section('title', 'Our Speakers | CEUTrainers')

@section('content')

<!-- BREADCRUMB START -->
<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Our <span class="color-secondary">Esteemed</span> Speakers</h1>
                <h3 class="heading-title">Learn from the <span class="color-secondary">Best,</span> become the Best!</h3>
                <span class="shape-line" style="color:#1ab69d"><i class="icon-19"></i></span>
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

<!-- SPEAKERS GRID START -->
<div class="edu-team-area team-area-2 edu-section-gap">
    <div class="container">
        <div class="row g-5">
            @foreach($speakers as $speaker)
                <div class="col-lg-4 col-md-6" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
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
<!-- SPEAKERS GRID END -->

@endsection
