@extends('layouts.app')

@section('title', 'Contact Us | CEUTrainers')

@section('styles')
<style type="text/css">
    #double li {
        width: 50%;
    }
    .circle {
        height: 50px;
        width: 50px;
        background-color: rgba(255, 0, 0, 0.4);
        border-radius: 50%;
    }
    .circle1 {
        height: 50px;
        width: 50px;
        background-color: rgba(26, 182, 157, 0.4);
        border-radius: 50%;
    }
    .square {
        text-align: center;
        height: 100px;
        width: 320px;
        padding: 25px;
        background-color: #fff;
        border-radius: 50px 8px 50px 8px;
        box-shadow: 3px 3px 5px 5px rgba(0, 0, 0, 0.05);
    }
    .square1 {
        text-align: center;
        height: 100px;
        width: 320px;
        padding: 25px;
        background-color: #fff;
        border-radius: 8px 50px 8px 50px;
        box-shadow: 3px 3px 5px 5px rgba(0, 0, 0, 0.05);
    }
    .contact-info-cards {
        display: flex;
        align-items: center;
        min-height: 560px;
        padding: 60px 0;
    }
    .contact-info-cards .row {
        justify-content: center;
        align-items: stretch;
    }
    .contact-info-cards .why-choose-box {
        height: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 16px !important;
    }
    .contact-info-cards .why-choose-box .icon {
        flex: 0 0 auto;
    }
    @media (max-width: 991px) {
        .contact-info-cards {
            min-height: auto;
            padding: 50px 0;
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
                <h1 class="title">Contact Us</h1>
                <h3 class="heading-title">We're Always <span class="color-secondary">Eager to Hear</span> From You!</h3>
                <span class="shape-line" style="color:#1ab69d"><i class="icon-19"></i></span>
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

<div class="container mt-5">
    <div class="contact-us-info">
        <div class="row">
            <div class="col-xs-12 content1 text-center" style="background:transparent; max-width: 1000px; margin: auto;">
                <p style="font-size:19px; color:black;">We value your feedback and are always looking for ways to improve.<br> If you have any suggestions or ideas, feedback, or you need technical support, have a billing question,<br>or just want to say Hello, we are here for you.</p>
                <h4 style="text-align: center; margin-bottom:10px" class="heading-title color-secondary">Contact us anytime!</h4>
                <center><span class="shape-line" style="color:#1ab69d"><i class="icon-19"></i></span></center>
            </div>
        </div>
    </div>
</div>

<!-- OFFICE INFO CARDS START -->
<section class="why-choose-area-2 contact-info-cards">
    <div class="container edublink-animated-shape">
        <div class="row g-5">
            <div class="col-lg-4" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                <div class="why-choose-box features-box color-primary-style" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; gap: 20px;">
                    <div class="icon" style="background-color: rgba(26, 182, 157, 0.1); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1ab69d; font-size: 24px;">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <h4 class="title" style="font-size: 1.25rem; margin-bottom: 10px; font-family: var(--font-heading);">Address</h4>
                        <p style="font-size:large; color: #52525b; line-height: 1.6; margin: 0;">304 S. Jones Blvd #5255,<br />Las Vegas, NV, 89107<br />United States</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                <div class="why-choose-box features-box color-secondary-style" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; gap: 20px;">
                    <div class="icon" style="background-color: rgba(ee, 74, 127, 0.1); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ee4a7f; font-size: 24px;">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <h4 class="title" style="font-size: 1.25rem; margin-bottom: 10px; font-family: var(--font-heading);">E-Mail</h4>
                        <p style="font-size:large; color: #52525b; line-height: 1.6; margin: 0;">
                            support@ceutrainers.com<br />
                            contact@ceutrainers.com<br />
                            info@ceutrainers.com
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                <div class="why-choose-box features-box color-extra08-style" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; gap: 20px;">
                    <div class="icon" style="background-color: rgba(244, 162, 97, 0.1); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #f4a261; font-size: 24px;">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <h4 class="title" style="font-size: 1.25rem; margin-bottom: 10px; font-family: var(--font-heading);">Hours of Operation</h4>
                        <p style="font-size:large; color: #52525b; line-height: 1.6; margin: 0;">
                            Mon - Fri : 09:00 - 20:00<br>
                            Sat : 10:00 - 14:00<br />
                            Sun : Closed
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <ul class="shape-group">
            <li class="shape-5" data-sal-delay="500" data-sal="fade" data-sal-duration="200"><span></span></li>
        </ul>
    </div>
</section>
<!-- OFFICE INFO CARDS END -->

<!-- LIVE ASSISTANCE START -->
<center>
    <div style="padding:50px 0px 0px 0px" class="online-academy-cta-wrapper edu-cta-banner-area bg-image">
        <h1>Live <span class="color-secondary">Assistance</span></h1>
        <span class="shape-line" style="color:#1ab69d"><i class="icon-19"></i></span>
        <p style="font-size:x-large; color:black">Need <span class="color-secondary">Immediate</span> Solution?<br />Talk to Our <span class="color-secondary">Live</span> Agent Now.</p>
        <div class="container mb-5">
            <div class="edu-cta-banner" style="background-color: transparent; box-shadow: none;">
                <div class="contact-us-info">
                    <div class="row justify-content-center g-4">
                        <div class="col-xl-6 col-lg-6 d-flex justify-content-center">
                            <div class="online-support square" data-sal-delay="600" data-sal="slide-right" data-sal-duration="1000" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div class="inner circle" style="display:inline-block">
                                    <i class="fa fa-phone" style="color:#EE4A62; font-size:25px; padding:12px"></i>
                                </div>
                                <div class="content" style="display:inline-block">
                                    <h4 class="title" style="margin: 0; font-weight:300; font-size:22px"><a href="tel:(+1)-432-755-5553">(+1)-432-755-5553</a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 d-flex justify-content-center">
                            <div class="online-support square1" data-sal-delay="1000" data-sal="slide-left" data-sal-duration="1000" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div class="inner circle1" style="display:inline-block">
                                    <i class="fa fa-commenting" style="color:#1AB69D; font-size:25px; padding:12px"></i>
                                </div>
                                <div class="content" style="display:inline-block">
                                    <h4 class="title" style="margin: 0; font-weight:300; font-size:22px"><a href="#" onclick="event.preventDefault(); Tawk_API.toggle();">Live Chat</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="shape-group">
                    <li class="shape-01 scene"><img data-depth="2.5" src="{{ asset('assets/images/cta/shape-10.png') }}" alt="shape" /></li>
                    <li class="shape-02 scene"><img data-depth="-2.5" src="{{ asset('assets/images/cta/shape-09.png') }}" alt="shape" /></li>
                    <li class="shape-03 scene"><img data-depth="-2" src="{{ asset('assets/images/cta/shape-08.png') }}" alt="shape" /></li>
                    <li class="shape-04 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape" /></li>
                </ul>
            </div>
        </div>
    </div>
</center>
<!-- LIVE ASSISTANCE END -->

<!-- GET IN TOUCH FORM START -->
<div style="padding:50px 0px 0px 0px"></div>
<div class="offset-xl-3 col-lg-6 mt-5 mb-5 mx-auto">
    <div class="contact-form" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <div class="section-title text-center">
            <h2 class="title">Get In <span class="color-secondary">Touch</span></h2>
            <span class="shape-line" style="color:#1ab69d"><i class="icon-19"></i></span>
            <p style="font-size:x-large; color:black">Fill this form below so that we can get to know you and your needs better.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 4px; padding: 15px; margin-bottom: 20px; font-weight: 500; background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; display: flex; justify-content: space-between; align-items: center;">
                <div><strong>Success!</strong> {{ session('success') }}</div>
                <button type="button" class="btn-close border-0 bg-transparent" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 4px; padding: 15px; margin-bottom: 20px; font-weight: 500; background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; display: flex; justify-content: space-between; align-items: center;">
                <ul class="mb-0 ps-0" style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li><i class="fa fa-exclamation-circle me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close border-0 bg-transparent" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></button>
            </div>
        @endif

        <form class="rnt-contact-form" method="POST" action="{{ route('contact.store') }}" onsubmit="document.getElementById('fullname').value = document.getElementById('fname').value + ' ' + document.getElementById('lname').value;">
            @csrf
            <input type="hidden" name="name" id="fullname">
            
            <div class="row row--10 g-3">
                <div class="col-12">
                    <div class="row g-3">
                        <div class="form-group col-md-6" style="margin-bottom: 15px;">
                            <input type="text" id="fname" placeholder="First name" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                        </div>
                        <div class="form-group col-md-6" style="margin-bottom: 15px;">
                            <input type="text" id="lname" placeholder="Last name" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row g-3">
                        <div class="form-group col-md-6" style="margin-bottom: 15px;">
                            <input type="text" name="phone" placeholder="Phone number" style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                        </div>
                        <div class="form-group col-md-6" style="margin-bottom: 15px;">
                            <input type="email" name="email" placeholder="Enter your Email Address" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                        </div>
                    </div>
                </div>
                <div class="form-group col-12" style="margin-bottom: 25px;">
                    <textarea name="message" cols="30" rows="4" placeholder="Your message" required style="width: 100%; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;"></textarea>
                </div>
                <div class="form-group col-12 text-center">
                    <button type="submit" class="rn-btn edu-btn btn-medium submit-btn" style="width:100%; font-size:large; font-weight: bold; border: none; color: white; padding: 15px 0;">Submit Message <i class="icon-4"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- GET IN TOUCH FORM END -->

<ul class="shape-group">
    <li class="shape-1"><span></span></li>
    <li class="shape-2 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape" /></li>
    <li class="shape-3 scene"><img data-depth="-2" src="{{ asset('assets/images/about/shape-15.png') }}" alt="shape" /></li>
    <li class="shape-4"><span></span></li>
    <li class="shape-5 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-07.png') }}" alt="shape" /></li>
</ul>

@endsection
