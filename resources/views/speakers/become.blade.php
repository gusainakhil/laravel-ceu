@extends('layouts.app')

@section('title', 'Become A Speaker | CEUTrainers')

@section('content')

<!-- BREADCRUMB START -->
<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Become A Speaker</h1>
                <h3 class="text-center heading-title">Mentor Young <span class="color-secondary">Learners</span></h3>
                <span class="shape-line" style="color:#1ab69d"><i class="icon-19"></i></span>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="contact-us-info">
            <div class="row">
                <div class="col-xs-6 content1" style="background:transparent; max-width: 1000px; margin: auto; text-align: center;">
                    <p style="font-size:19px; color:black;">Trainings are difficult or impossible without expert guidance. Your guidance helps trainees grasp complex concepts and apply them effectively. Your expertise, experience, and insights are invaluable for helping learners achieve their goals and develop mastery in their field.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Area -->
    <div class="offset-xl-3 col-lg-6 mt-5 mb-5 mx-auto">
        <div class="contact-form" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <form class="rnt-contact-form rwt-dynamic-form" id="Becomespeaker" method="POST" action="#" onsubmit="event.preventDefault(); Swal.fire({icon: 'success', title: 'Success!', text: 'Your speaker application has been submitted successfully!'}); this.reset();">
                @csrf
                <div class="row row--10 g-3">
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="form-group col-md-6" style="margin-bottom: 15px;">
                                <input type="text" name="fname" placeholder="First name" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 15px;">
                                <input type="text" name="lname" placeholder="Last name" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="form-group col-md-6" style="margin-bottom: 15px;">
                                <input type="number" name="phone_no" placeholder="Phone number" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 15px;">
                                <input type="email" name="email" placeholder="Enter your Email" required style="width: 100%; height: 50px; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12" style="margin-bottom: 15px;">
                        <textarea name="experience" cols="30" rows="3" placeholder="Qualification and Experience" required style="width: 100%; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;"></textarea>
                    </div>
                    <div class="form-group col-12" style="margin-bottom: 25px;">
                        <textarea name="bio" cols="30" rows="3" placeholder="Bio" required style="width: 100%; border-radius: 3px; background-color: #f5f5f5; border: 1px solid #e5e5e5; padding: 10px 15px;"></textarea>
                    </div>
                    <div class="form-group col-12 text-center">
                        <button class="rn-btn edu-btn btn-medium submit-btn" name="submit" type="submit" style="width: 100%; font-weight: bold; background-color: #1ab69d; border-color: #1ab69d; color: white; padding: 15px 0;">Join Us <i class="icon-4"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact Info Cards -->
    <section class="why-choose-area-2 section-gap-large">
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

    <ul class="shape-group">
        <li class="shape-1"><span></span></li>
        <li class="shape-2 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-13.png') }}" alt="shape" /></li>
        <li class="shape-3 scene"><img data-depth="-2" src="{{ asset('assets/images/about/shape-15.png') }}" alt="shape" /></li>
        <li class="shape-4"><span></span></li>
        <li class="shape-5 scene"><img data-depth="2" src="{{ asset('assets/images/about/shape-07.png') }}" alt="shape" /></li>
    </ul>
</div>

@endsection

@section('scripts')
<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
