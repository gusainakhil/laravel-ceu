@extends('layouts.app')

@section('title', 'Privacy Policy | CEUTrainers')

@section('styles')
<style>
    .privacy-policy-area .privacy-policy {
        background: #ffffff;
        border: 1px solid #edf3f1;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 12px 32px rgba(19, 35, 31, 0.04);
    }
    
    .privacy-policy-area .text-block {
        margin-bottom: 35px;
    }
    
    .privacy-policy-area .text-block:last-child {
        margin-bottom: 0;
    }
    
    .privacy-policy-area .title {
        font-weight: 800;
        color: #171717;
        margin-bottom: 18px;
    }
    
    .privacy-policy-area h3.title {
        font-size: 24px;
        border-bottom: 2px solid #edf3f1;
        padding-bottom: 12px;
    }
    
    .privacy-policy-area h4.title {
        font-size: 20px;
        margin-top: 10px;
    }
    
    .privacy-policy-area p {
        font-size: 16px;
        line-height: 1.8;
        color: #60736e;
        margin-bottom: 20px;
    }
    
    .privacy-policy-area p b {
        color: #171717;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
        font-size: 16.5px;
    }
    
    .privacy-policy-area ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .privacy-policy-area ul li {
        font-size: 16px;
        line-height: 1.8;
        color: #60736e;
        position: relative;
        padding-left: 24px;
        margin-bottom: 12px;
    }
    
    .privacy-policy-area ul li:last-child {
        margin-bottom: 0;
    }
    
    .privacy-policy-area ul li::before {
        content: "\f0a4";
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
                <h1 class="title">Privacy <span class="color-secondary">Policy</span></h1>
                <span class="shape-line" style="text-align:left; color:#1AB69D"><i class="icon-19"></i></span>
            </div>
        </div>
    </div>
</div>

<!-- PRIVACY POLICY SECTION START -->
<section class="privacy-policy-area terms-condition-area" style="padding: 80px 0;">
    <div class="container">
        <div class="row row--30">
            <div class="col-lg-12">
                <div class="privacy-policy terms-condition">
                    <div class="text-block">
                        <h3 class="title">Privacy Notice Highlights:</h3>
                        
                        <p><b>What personal information do we process?</b> When you visit, use, or navigate our Services, we may process personal information depending on how you interact with CEU Trainers and the Services, the choices you make, and the products and features you use.</p>

                        <p><b>Do we process any sensitive personal information?</b> We do not process sensitive personal information.</p>
                        
                        <p><b>Do we receive any information from third parties?</b> We do not receive any information from third parties.</p>
                        
                        <p><b>How do we process your information?</b> We process your information to provide, improve, and administer our Services, communicate with you, for security and fraud prevention, and to comply with law. We may also process your information for other purposes with your consent. We process your information only when we have a valid legal reason to do so.</p>
                        
                        <p><b>In what situations and with which parties do we share personal information?</b> We may share information in specific situations and with specific third parties.</p>
                        
                        <p><b>How do we keep your information safe?</b> We have organizational and technical processes and procedures in place to protect your personal information. However, no electronic transmission over the internet or information storage technology can be guaranteed to be 100% secure, so we cannot promise or guarantee that hackers, cybercriminals, or other unauthorized third parties will not be able to defeat our security and improperly collect, access, steal, or modify your information.</p>
                        
                        <p><b>What are your rights?</b> Depending on where you are located geographically, the applicable privacy law may mean you have certain rights regarding your personal information.</p>
                        
                        <p><b>How do you exercise your rights?</b> The easiest way to exercise your rights is by filling out our data subject request form available here or by contacting us. We will consider and act upon any request in accordance with applicable data protection laws.</p>
                    </div>
                    
                    <div class="text-block" style="border-top: 2px solid #edf3f1; padding-top: 30px; margin-top: 30px;">
                        <p>Want to learn more about what CEU Trainers does with any information we collect? Continue reading to review the notice in full.</p>
                        <h4 class="title">TABLE OF CONTENTS</h4>
                        <ul>
                            <li>WHAT INFORMATION DO WE COLLECT?</li>
                            <li>HOW DO WE PROCESS YOUR INFORMATION?</li>
                            <li>WHEN AND WITH WHOM DO WE SHARE YOUR PERSONAL INFORMATION?</li>
                            <li>DO WE USE COOKIES AND OTHER TRACKING TECHNOLOGIES?</li>
                            <li>HOW LONG DO WE KEEP YOUR INFORMATION?</li>
                            <li>HOW DO WE KEEP YOUR INFORMATION SAFE?</li>
                            <li>DO WE COLLECT INFORMATION FROM MINORS?</li>
                            <li>WHAT ARE YOUR PRIVACY RIGHTS?</li>
                            <li>CONTROLS FOR DO-NOT-TRACK FEATURES</li>
                            <li>DO CALIFORNIA RESIDENTS HAVE SPECIFIC PRIVACY RIGHTS?</li>
                            <li>DO VIRGINIA RESIDENTS HAVE SPECIFIC PRIVACY RIGHTS?</li>
                            <li>DO WE MAKE UPDATES TO THIS NOTICE?</li>
                            <li>HOW CAN YOU CONTACT US ABOUT THIS NOTICE?</li>
                            <li>HOW CAN YOU REVIEW, UPDATE, OR DELETE THE DATA WE COLLECT FROM YOU?</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
