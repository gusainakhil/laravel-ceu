<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'CEU Trainers | Online Education Platform')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="CEUTrainers provides premium professional training, webinars, and continuing education resources in HR, Payroll compliance, and construction." />
    <meta name="google-site-verification" content="-3V3oOBiqPfE0SIkmRHiE1zqnO_MDrTvg0oKPMRMNxo" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/Favicon.png') }}" />
    
    <!-- CSS Vendor Assets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/icomoon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/remixicon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnifypopup.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/lightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/animation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/jqueru-ui-min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/tipped.min.css') }}" />
    
    <!-- Calendar Stylesheet & Script -->
    <link href="{{ asset('assets/Calender/EventCalender.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/Calender/EventCalender.js') }}" type="text/javascript"></script>
    
    <!-- Main Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <style>
        .site-flash-wrap {
            left: 0;
            pointer-events: none;
            position: fixed;
            right: 0;
            top: 138px;
            z-index: 9999;
        }

        .site-flash {
            align-items: center;
            border: 1px solid transparent;
            border-left-width: 5px;
            border-radius: 8px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-left: auto;
            margin-right: auto;
            max-width: 1180px;
            min-height: 58px;
            padding: 16px 48px 16px 18px;
            pointer-events: auto;
            position: relative;
            transition: opacity 0.25s ease, transform 0.25s ease;
            width: calc(100% - 32px);
        }

        .site-flash.is-hiding {
            opacity: 0;
            transform: translateY(-10px);
        }

        .site-flash-success {
            background: #f0fbf9;
            border-color: rgba(26, 182, 157, 0.28);
            border-left-color: #1ab69d;
            color: #12947f;
        }

        .site-flash-danger {
            background: #fdf2f6;
            border-color: rgba(238, 74, 127, 0.24);
            border-left-color: #ee4a7f;
            color: #d63869;
        }

        .site-flash-warning {
            background: #fffdf5;
            border-color: rgba(224, 168, 0, 0.25);
            border-left-color: #e0a800;
            color: #856404;
        }

        .site-flash-message {
            font-size: 16px;
            line-height: 1.45;
        }

        .site-flash-message strong {
            font-weight: 800;
        }

        .site-flash-close {
            align-items: center;
            background: transparent;
            border: 0;
            color: currentColor;
            display: flex;
            font-size: 24px;
            height: 36px;
            justify-content: center;
            opacity: 0.65;
            padding: 0;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
        }

        .site-flash-close:hover {
            opacity: 1;
        }

        @media (max-width: 1199px) {
            .site-flash-wrap {
                top: 96px;
            }
        }

        @media (max-width: 767px) {
            .site-flash-wrap {
                top: 76px;
            }

            .site-flash {
                padding: 14px 44px 14px 15px;
            }

            .site-flash-message {
                font-size: 14px;
            }
        }
    </style>
    
    @yield('styles')
</head>

<body class="sticky-header">
    <div id="main-wrapper" class="main-wrapper">
        
        <!-- HEADER START -->
        <header class="edu-header header-style-3">
            <div class="header-top-bar">
                <div class="container">
                    <div class="header-top">
                        <div class="header-top-left">
                            <ul class="header-info">
                                <li><a href="tel:(+1)-432-755-5553"><i class="icon-phone"></i>Call: (+1)-432-755-5553</a></li>
                                <li><a href="mailto:support@ceutrainers.com" target="_blank"><i class="icon-envelope"></i>Email: support@ceutrainers.com</a></li>
                            </ul>
                        </div>
                        <div class="header-top-right">
                            <ul class="header-info">
                                @auth
                                    <li><a href="{{ route('dashboard') }}">Dashboard ({{ Auth::user()->name }})</a></li>
                                    <li>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edu-sticky-placeholder"></div>
            <div class="header-mainmenu">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-brand">
                            <div class="logo">
                                <a href="{{ route('home') }}">
                                    <img class="logo-light" src="{{ asset('assets/img/Logo.png') }}" alt="CEUTrainers Logo" style="max-height: 50px; width: auto;" />
                                    <img class="logo-dark" src="{{ asset('assets/img/Logo.png') }}" alt="CEUTrainers Logo" style="max-height: 50px; width: auto;" />
                                </a>
                            </div>
                        </div>
                        <div class="header-mainnav">
                            <nav class="mainmenu-nav">
                                <ul class="mainmenu">
                                    <li><a href="{{ route('subscription.index') }}">Subscription</a></li>
                                    <!-- <li class="has-droupdown"><a href="#">Industry</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('webinar.index', ['industry' => 2]) }}">Human Resource</a></li>
                                            <li><a href="{{ route('webinar.index', ['industry' => 3]) }}">Payroll & Taxation</a></li>
                                            <li><a href="{{ route('webinar.index', ['industry' => 1]) }}">BFSI & Accounting</a></li>
                                            <li><a href="{{ route('webinar.index', ['industry' => 4]) }}">Housing & Construction</a></li>
                                        </ul>
                                    </li> -->
                                          <li class="has-droupdown"><a href="#">Industry</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('webinar.index') }}">Human Resource</a></li>
                                            <li><a href="{{ route('webinar.index') }}">Payroll & Taxation</a></li>
                                            <li><a href="{{ route('webinar.index') }}">BFSI & Accounting</a></li>
                                            <li><a href="{{ route('webinar.index') }}">Housing & Construction</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">Webinar</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('webinar.index') }}">Live</a></li>
                                            <li><a href="{{ route('webinar.index') }}">On Demand</a></li>
                                            <li><a href="{{ route('webinar.index') }}">eTranscript</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">Speakers</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('speakers.index') }}">Our Speakers</a></li>
                                            <li><a href="{{ route('speakers.become') }}">Become a Speaker</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">Help</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                                            <li><a href="{{ route('faq.index') }}">FAQs</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-right">
                            <ul class="header-action">
                                <li class="icon cart-icon">
                                    <a href="{{ route('cart.index') }}" class="cart-icon" id="cartLink">
                                        <i class="icon-3"></i>
                                        <span class="count" id="cart_count">
                                            @php
                                                $activeCart = Auth::check()
                                                    ? \App\Models\Cart::where('user_id', Auth::id())->where('status', 'active')->first()
                                                    : \App\Models\Cart::where('session_id', session()->getId())->where('status', 'active')->first();

                                                $cartCount = $activeCart ? $activeCart->items()->count() : 0;
                                            @endphp
                                            {{ $cartCount }}
                                        </span>
                                    </a>
                                </li>
                                <li class="mobile-menu-bar d-block d-xl-none">
                                    <button class="hamberger-button">
                                        <i class="icon-54"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Popup Mobile Menu -->
            <div class="popup-mobile-menu">
                <div class="inner">
                    <div class="header-top">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img class="logo-light" src="{{ asset('assets/img/Logo.png') }}" alt="CEUTrainers Logo" style="max-height: 45px; width: auto;" />
                                <img class="logo-dark" src="{{ asset('assets/img/Logo.png') }}" alt="CEUTrainers Logo" style="max-height: 45px; width: auto;" />
                            </a>
                        </div>
                        <div class="close-menu">
                            <button class="close-button">
                                <i class="icon-73"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="mainmenu">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('subscription.index') }}">Subscription</a></li>
                        <li class="has-droupdown"><a href="#">Industry</a>
                            <ul class="submenu">
                                <li><a href="{{ route('webinar.index', ['industry' => 2]) }}">Human Resource</a></li>
                                <li><a href="{{ route('webinar.index', ['industry' => 3]) }}">Payroll & Taxation</a></li>
                                <li><a href="{{ route('webinar.index', ['industry' => 1]) }}">BFSI & Accounting</a></li>
                                <li><a href="{{ route('webinar.index', ['industry' => 4]) }}">Housing & Construction</a></li>
                            </ul>
                        </li>
                        <li class="has-droupdown"><a href="#">Webinar</a>
                            <ul class="submenu">
                                <li><a href="{{ route('webinar.index') }}">Live</a></li>
                                <li><a href="{{ route('webinar.index') }}">On Demand</a></li>
                                <li><a href="{{ route('webinar.index') }}">eTranscript</a></li>
                            </ul>
                        </li>
                        <li class="has-droupdown"><a href="#">Speakers</a>
                            <ul class="submenu">
                                <li><a href="{{ route('speakers.index') }}">Our Speakers</a></li>
                                <li><a href="{{ route('speakers.become') }}">Become a Speaker</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                        <li><a href="{{ route('faq.index') }}">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- HEADER END -->

        <!-- ALERTS AND NOTIFICATIONS -->
        @php
            $showGlobalValidationErrors = $errors->any() && !request()->routeIs('cart.checkout');
            $flashType = null;
            $flashMessage = null;
            $flashIcon = null;
            $flashTitle = null;

            if (session('success')) {
                $flashType = 'success';
                $flashMessage = session('success');
                $flashIcon = 'fa-check-circle';
                $flashTitle = 'Success!';
            } elseif (session('error')) {
                $flashType = 'danger';
                $flashMessage = session('error');
                $flashIcon = 'fa-exclamation-circle';
                $flashTitle = 'Error!';
            } elseif (session('warning')) {
                $flashType = 'warning';
                $flashMessage = session('warning');
                $flashIcon = 'fa-warning';
                $flashTitle = 'Warning!';
            } elseif ($showGlobalValidationErrors) {
                $flashType = 'danger';
                $flashMessage = $errors->first();
                $flashIcon = 'fa-times-circle';
                $flashTitle = 'Validation Error';
            }
        @endphp
        @if($flashMessage)
            <div class="site-flash-wrap" id="siteFlashWrap">
                <div class="site-flash site-flash-{{ $flashType }}" id="siteFlash" role="status" aria-live="polite">
                    <div class="site-flash-message">
                        <strong><i class="fa {{ $flashIcon }} me-2"></i>{{ $flashTitle }}</strong> {{ $flashMessage }}
                    </div>
                    <button type="button" class="site-flash-close" id="siteFlashClose" aria-label="Close">&times;</button>
                </div>
            </div>
        @endif

        <!-- DYNAMIC CONTENT -->
        <main>
            @yield('content')
        </main>

        <!-- FOOTER START -->
        <footer class="edu-footer footer-dark bg-image footer-style-2">
            <div class="footer-top footer-top-2">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="edu-footer-widget">
                                <div class="logo">
                                    <a href="{{ route('home') }}">
                                        <img class="logo-light" src="{{ asset('assets/img/lightLogo.png') }}" alt="CEUTrainers Logo" style="max-height: 50px; width: auto;" />
                                    </a>
                                </div>
                                <br />
                                <div class="widget-information">
                                    <ul class="information-list">
                                        <li><span>Add:</span>304 S. Jones Blvd #5255, Las Vegas, NV, 89107 United States</li>
                                        <li><span>Call:</span><a href="tel:(+1)-432-755-5553">(+1)-432-755-5553</a></li>
                                        <li><span>Email:</span><a href="mailto:support@ceutrainers.com" target="_blank">info@ceutrainers.com</a></li>
                                    </ul>
                                </div>
                                <br />
                                <ul class="social-share icon-transparent">
                                    <li><a href="#" class="color-fb"><i class="icon-facebook"></i></a></li>
                                    <li><a href="#" class="color-linkd"><i class="icon-linkedin2"></i></a></li>
                                    <li><a href="#" class="color-ig"><i class="icon-instagram"></i></a></li>
                                    <li><a href="#" class="color-twitter"><i class="icon-twitter"></i></a></li>
                                    <li><a href="#" class="color-yt"><i class="icon-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="edu-footer-widget explore-widget">
                                <h4 class="widget-title">Links</h4>
                                <div class="inner">
                                    <ul class="footer-link link-hover">
                                        <li><a href="{{ route('home') }}">About Us</a></li>
                                        <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                                        <li><a href="{{ route('terms-condition') }}">Terms of Use</a></li>
                                        <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                        <li><a href="#">Refund Policy</a></li>
                                        <li><a href="#">Career</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="edu-footer-widget quick-link-widget">
                                <h4 class="widget-title">Online Platform</h4>
                                <div class="inner">
                                    <ul class="footer-link link-hover">
                                        <li><a href="{{ route('webinar.index', ['types' => ['on_demand']]) }}">On Demand Training</a></li>
                                        <li><a href="{{ route('webinar.index', ['types' => ['live']]) }}">Live Training</a></li>
                                        <li><a href="{{ route('webinar.index', ['types' => ['etranscript']]) }}">eTranscript</a></li>
                                        <li><a href="{{ route('faq.index') }}">FAQ's</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="edu-footer-widget">
                                <h4 class="widget-title">Newsletter Subscriptions</h4>
                                <div class="inner">
                                    <p class="description">Subscribe to our newsletter to get latest course updates.</p>
                                    <div class="input-group footer-subscription-form">
                                        <input type="email" class="form-control" placeholder="Your email">
                                        <button class="edu-btn btn-medium" style="font-size:large" type="button">Subscribe <i class="icon-4"></i></button>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-6 col-md-6">
                                            <img src="{{ asset('assets/icons/securePayment.png') }}" alt="Secure Payment" />
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <img src="{{ asset('assets/icons/paypal.png') }}" alt="Paypal" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom text-center">
                <div class="container">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} CEUTrainers. All Rights Reserved. Empowering Professionals Globally.</p>
                </div>
            </div>
        </footer>
        <!-- FOOTER END -->

    </div>

    <!-- Scroll To Top -->
    <div class="rn-progress-parent">
        <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- JS Vendor Assets -->
    <script src="{{ asset('assets/js/vendor/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/sal.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/backtotop.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/magnifypopup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/isotop.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/imageloaded.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/paralax.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/paralax-scroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/svg-inject.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/vivus.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tipped.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/smooth-scroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/isInViewport.jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    
    <!-- Site Application Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flash = document.getElementById('siteFlash');
            var close = document.getElementById('siteFlashClose');

            if (!flash) {
                return;
            }

            var dismiss = function() {
                flash.classList.add('is-hiding');
                window.setTimeout(function() {
                    flash.remove();
                }, 260);
            };

            close?.addEventListener('click', dismiss);
            window.setTimeout(dismiss, 4500);
        });
    </script>

    <!-- Tawk.to Script -->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/65a577748d261e1b5f53a883/1hk75l88g';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>

    @yield('scripts')
</body>

</html>
