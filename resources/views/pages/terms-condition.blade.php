@extends('layouts.app')

@section('title', 'Terms & Conditions | CEUTrainers')

@section('styles')
<style>
    .terms-condition-area .privacy-policy {
        background: #ffffff;
        border: 1px solid #edf3f1;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 12px 32px rgba(19, 35, 31, 0.04);
    }
    
    .terms-condition-area .text-block {
        margin-bottom: 35px;
    }
    
    .terms-condition-area .text-block:last-child {
        margin-bottom: 0;
    }
    
    .terms-condition-area .title {
        font-weight: 800;
        color: #171717;
        margin-bottom: 18px;
    }
    
    .terms-condition-area h3.title {
        font-size: 24px;
        border-bottom: 2px solid #edf3f1;
        padding-bottom: 12px;
    }
    
    .terms-condition-area h4.title {
        font-size: 20px;
        margin-top: 10px;
    }
    
    .terms-condition-area p {
        font-size: 16px;
        line-height: 1.8;
        color: #60736e;
        margin-bottom: 15px;
    }
    
    .terms-condition-area ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .terms-condition-area ul li {
        font-size: 16px;
        line-height: 1.8;
        color: #60736e;
        position: relative;
        padding-left: 24px;
        margin-bottom: 12px;
    }
    
    .terms-condition-area ul li:last-child {
        margin-bottom: 0;
    }
    
    .terms-condition-area ul li::before {
        content: "\f00c";
        font-family: "FontAwesome";
        color: #1ab69d;
        font-size: 14px;
        position: absolute;
        left: 0;
        top: 2px;
    }
</style>
@endsection

@section('content')

<!-- BREADCRUMB START -->
<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Terms & <span class="color-secondary">Conditions</span></h1>
                <span class="shape-line" style="text-align:left; color:#1AB69D"><i class="icon-19"></i></span>
            </div>
        </div>
    </div>
</div>

<!-- TERMS & CONDITIONS SECTION START -->
<section class="privacy-policy-area terms-condition-area" style="padding: 80px 0;">
    <div class="container">
        <div class="row row--30">
            <div class="col-lg-12">
                <div class="privacy-policy terms-condition">
                    <div class="text-block">
                        <h3 class="title">Definitions of Basic Terms, Rights and Restriction:</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. </p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p>
                    </div>
                    
                    <div class="text-block">
                        <h4 class="title">Basic Terms</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nis aliquip commodo consequat aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat. </p>
                    </div>
                    
                    <div class="text-block">
                        <h4 class="title">Rights & Restrictions</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <ul>
                            <li>Members must be at least 18 years of age.</li>
                            <li>Members are granted a time-limited, non-exclusive, revocable, nontransferable, and non-sublicenseable right to access that portion of the online course corresponding to the purchase.</li>
                            <li>The portion of the online course corresponding to the purchase will be available to the Member as long as the course is maintained by the Company, which will be a minimum of one year after Member’s purchase.</li>
                            <li>The videos in the course are provided as a video stream and are not downloadable.</li>
                            <li>By agreeing to grant such access, the Company does not obligate itself to maintain the course, or to maintain it in its present form. </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
