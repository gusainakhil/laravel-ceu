@extends('layouts.app')

@section('title', $speaker->name . ' | CEUTrainers')

@section('styles')
<style>
    .speaker-profile-area {
        background: #fff;
        padding: 76px 0 78px;
    }

    .speaker-profile-image {
        aspect-ratio: 1 / 1;
        border-radius: 50%;
        display: block;
        height: auto;
        max-width: 400px;
        object-fit: cover;
        width: 100%;
    }

    .speaker-profile-copy {
        color: #181818;
        font-size: 18px;
        font-weight: 400;
        line-height: 1.72;
    }

    .speaker-profile-copy p {
        margin-bottom: 24px;
    }

    .speaker-profile-copy strong {
        font-weight: 900;
    }

    .speaker-profile-designation {
        color: #1ab69d;
        font-size: 22px;
        font-weight: 500;
        line-height: 1.35;
        margin-top: 8px;
    }

    @media (max-width: 991px) {
        .speaker-profile-area {
            padding: 50px 0 60px;
        }

        .speaker-profile-image {
            margin: 0 auto 30px;
            max-width: 320px;
        }

        .speaker-profile-copy {
            font-size: 17px;
        }
    }
</style>
@endsection

@section('content')
@php
    $speakerImg = $speaker->image;
    if (!$speakerImg) {
        $speakerImg = asset('ceuadmin-assets/assets/images/profile_av.svg');
    } elseif (!str_starts_with($speakerImg, 'http')) {
        $speakerImg = asset('ceuadmin-assets/assets/images/speaker/' . $speakerImg);
    }

    $speakerBio = $speaker->bio
        ? strip_tags(html_entity_decode($speaker->bio), '<p><strong><b><em><i><br><ul><ol><li>')
        : null;
@endphp

<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">{{ $speaker->name }}</h1>
                @if($speaker->designation)
                    <h3 class="speaker-profile-designation">{{ $speaker->designation }}</h3>
                @endif
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

<section class="speaker-profile-area">
    <div class="container">
        <div class="row align-items-start g-5">
            <div class="col-lg-4">
                <img class="speaker-profile-image" src="{{ $speakerImg }}" alt="{{ $speaker->name }}">
            </div>
            <div class="col-lg-8">
                <div class="speaker-profile-copy">
                    @if($speakerBio)
                        {!! $speakerBio !!}
                    @else
                        <p><strong>{{ $speaker->name }}</strong>{{ $speaker->designation ? ', ' . $speaker->designation . ',' : '' }} is one of our expert speakers at CEUTrainers.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
