<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#ec1d23" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <link rel="shortcut icon"
        href="@if (@$setting->site_logo) {{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }} @else {{ asset('assets/images/logo.png') }} @endif"
        type="image/x-icon">
    <link rel="icon"
        href="@if (@$setting->site_logo) {{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }} @else {{ asset('assets/images/logo.png') }} @endif"
        type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">
</head>

<body>

    <!-- Modal  -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quick Inquery Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="popup-form">
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea name="" class="form-control" placeholder="Message"></textarea>
                            </div>
                            <button type="submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End  -->

    <!-- Top Header  -->
    <div class="top-header">
        <div class="container">
            <div class="th-wrap">
                <div class="th-left">
                    <ul>
                        <li>
                            <a href="#"><i class="las la-print"></i> Govt. Lic. No.: 1171/073/074</a>
                        </li>
                        <li>
                            <a href="#"><i class="las la-street-view"></i> {{ @$setting->location }}</a>
                        </li>
                        <li>
                            <a href="#"><i class="las la-inbox"></i> {{ @$setting->official_email }}</a>
                        </li>
                        <li>
                            <a href="tel:{{ @$setting->contact }}"><i class="las la-phone"></i>
                                {{ @$setting->contact }}</a>
                        </li>
                    </ul>
                </div>
                <div class="th-right">
                    <h3>Follow us: </h3>
                    <ul>
                        <li>
                            <a href="{{ @$setting->fb_link }}" target="_blank"><img
                                    src="{{ asset('assets/images/social-media/facebook.png') }}" alt="images"></a>
                        </li>
                        <li>
                            <a href="{{ @$setting->insta_link }}" target="_blank"><img
                                    src="{{ asset('assets/images/social-media/instagram.png') }}" alt="images"></a>
                        </li>
                        <li>
                            <a href="{{ @$setting->tiktok_link }}" target="_blank"><img
                                    src="{{ asset('assets/images/social-media/tiktok.png') }}" alt="images"></a>
                        </li>
                        <li>
                            <a href="tel:{{ @$setting->whatsapp }}"><img
                                    src="{{ asset('assets/images/social-media/whatsapp.png') }}" alt="images"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Header End  -->

    <!-- Header  -->
    <header class="header">
        <div class="container">
            <div class="header-wrap">
                <div class="header-left">
                    <div class="logo">

                        @if (@$setting->site_logo)
                            <a href="/"><img
                                    src="{{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }}"
                                    alt="logo" title="Logo"></a>
                        @else
                            <a href="/"><img src="{{ asset('assets/images/logo.png') }}" alt="logo"
                                    title="Logo"></a>
                        @endif
                        {{-- <span class="slogon">Ditya International <br>Pvt. Ltd.</span> --}}
                    </div>
                </div>
                <div class="header-right">
                    <div class="header-navigation">
                        <ul>
                            <li
                                class="{{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.home' ? 'active' : '' }}">
                                <a href="{{ route('web.home') }}">Home</a>
                            </li>
                            {{-- <li
                                class="{{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.aboutUs' ? 'active' : '' }}">
                                <a href="{{ route('web.home') }}"><a href="{{ route('web.aboutUs') }}">About</a>
                            </li> --}}
                            <li class="sub-menu-item {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.aboutUs' || \Illuminate\Support\Facades\Route::currentRouteName() == 'web.recruitment' ? 'active' : '' }}">
                                <a href="#">About Us <i class="las la-angle-down"></i></a>
                                <div class="sub-menu">
                                    <ul>
                                        <li><a href="{{ route('web.aboutUs') }}">About</a></li>
                                        <li><a href="{{ route('web.recruitment') }}">Recruitment Process</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li
                                class="sub-menu-item {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.services' || \Illuminate\Support\Facades\Route::currentRouteName() == 'web.singleService' ? 'active' : '' }}">
                                <a href="{{ route('web.services') }}">Services <i class="las la-angle-down"></i></a>
                                <div class="sub-menu">
                                    <ul>
                                        @foreach ($services as $service)
                                            <li><a
                                                    href="{{ route('web.singleService', $service->slug) }}">{{ $service->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li
                                class="{{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.news' ? 'active' : '' }}">
                                <a href="{{ route('web.news') }}">News</a>
                            </li>
                            <li
                                class="{{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.gallery' || \Illuminate\Support\Facades\Route::currentRouteName() == 'web.galleryDetails' ? 'active' : '' }}">
                                <a href="{{ route('web.gallery') }}">Gallery</a>
                            </li>
                            <li
                                class="{{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.contactUs' ? 'active' : '' }}">
                                <a href="{{ route('web.contactUs') }}">Contact</a>
                            </li>
                            <li
                                class="{{ \Illuminate\Support\Facades\Route::currentRouteName() == 'web.vaccancy' ? 'active' : '' }}">
                                <a href="{{ route('web.vaccancy') }}">Vacancies</a>
                            </li>
                        </ul>
                    </div>
                    <div class="header-utilities">
                        <div class="header-utilities-btns">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle effect-button" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Login/ Register
                                </button>
                                <ul class="dropdown-menu" style="margin-top: 15px;">
                                    <li><a class="dropdown-item" href="#">Candidate Login/Register</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.login') }}">Employer Login</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('user.login') }}">Staff Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="header-utilities-mobile">
                            <ul>
                                <li><a href="login.php"><i class="las la-sign-in-alt"></i></a></li>
                                <li><a href="register.php"><i class="las la-user"></i></a></li>
                            </ul>
                        </div>
                        <div class="toggle-btn" title="Menu">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End  -->

    <!-- Mobile Menu -->
    <div id="mySidenav" class="sidenav">
        <div class="mobile-logo">
            <a href="{{ route('web.home') }}"><img
                    src="{{ @$setting->logo ? url('/storage/public/uploads/chairman-image/' . @$setting->logo) : asset('web/img/logo.png') }}"
                    alt="logo"></a>
            <a href="javascript:void(0)" id="close-btn" class="closebtn"><i class="las la-times"></i> </a>
        </div>
        <div class="no-bdr1">
            <ul id="menu1">
                <li><a href="{{ route('web.home') }}">Home</a></li>
                {{-- <li><a href="{{ route('web.aboutUs') }}">About Us</a></li> --}}
                <li>
                    <a href="#" class="has-arrow">About Us</a>
                    <ul>
                        <li><a href="{{ route('web.aboutUs') }}">About</a></li>
                        <li><a href="{{ route('web.recruitment') }}">Recruitment Process</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('web.services') }}" class="has-arrow">Services</a>
                    <ul>
                        @foreach ($services as $service)
                            <li><a href="{{ route('web.singleService', $service->slug) }}">{{ $service->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('web.news') }}">News</a></li>
                <li><a href="{{ route('web.gallery') }}">Gallery</a></li>
                <li><a href="{{ route('web.contactUs') }}">Contact</a></li>
                <li><a href="{{ route('web.gallery') }}">Gallery</a></li>
                <li><a href="{{ route('web.vaccancy') }}">Vacancies</a></li>
            </ul>
            <div class="mobile-contact">
                <ul>
                    <li><a href="tel:{{ @$setting->contact }}"><i class="las la-phone-volume"></i> {{ @$setting->contact }}</a></li>
                    <li><a href="#"><i class="las la-envelope-open-text"></i>
                            {{ @$setting->official_email }}</a></li>
                </ul>
            </div>
            <div class="social-media">
                <ul>
                    <li>
                        <a href="{{ @$setting->fb_link }}"><img
                                src="{{ asset('assets/images/social-media/facebook.png') }}" alt="images"></a>
                    </li>
                    <li>
                        <a href="{{ @$setting->insta_link }}"><img
                                src="{{ asset('assets/images/social-media/instagram.png') }}" alt="images"></a>
                    </li>
                    <li>
                        <a href="{{ @$setting->tiktok_link }}"><img src="{{ asset('assets/images/social-media/tiktok.png') }}"
                                alt="images"></a>
                    </li>
                    <li>
                        <a href="tel:{{ @$setting->whatsapp }}"><img src="{{ asset('assets/images/social-media/whatsapp.png') }}"
                                alt="images"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Mobile Menu End -->
