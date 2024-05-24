@extends('frontend.layout')

@section('title')
    Home | {{ config('app.name') }}
@endsection
<!-- Skip Ads -->
{{-- <div class="skip-ads">
    <div class="skip-ads-wrap">
        <div class="skip-ads-col only-desktop">
            <div class="skip-ads-head">
                <button type="" class="btn btn-primary"><i class="las la-times"></i></button>
            </div>
            <a href="#" title=""><img src="{{ asset('web/img/skip-desktop.jpg') }}" alt="images"></a>
        </div>
    </div>
</div> --}}
<!-- Skip Ads End -->
@section('content')

    <!-- Slider  -->
    <section class='slider'>
        <div class='slider-wrap'>
            <div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel' data-bs-pause='true'>
                <div class='carousel-inner'>

                    @foreach ($sliders as $key => $slider)
                        <div class='carousel-item @if ($key == 0) active @endif'>
                            <img src='{{ url('/storage/uploads/sliders/' . $slider->image) }}' alt='Slider'>
                            <div class='slider-caption'>
                                <div class='slider-caption-col animate-true reach_section delay4'
                                    data-animatetype='reach_section' data-delay='delay4'>
                                    <h1 class='animate-true'>{{ $slider->title }}</h1>
                                        {!! \Illuminate\Support\Str::limit($slider->description, 150, $end = '...') !!}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade'
                    data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Previous</span>
                </button>
                <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleFade'
                    data-bs-slide='next'>
                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Next</span>
                </button>
            </div>
        </div>
    </section>
    <!-- Slider End  -->

    <!-- Content Section  -->
    <section class="content-section" style="background-image:url('{{ asset('web/img/parallax.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 animate-true transition reach_section delay1"
                    data-animatetype="reach_section" data-delay="delay1">
                    <div class="content-points-wrap">
                        <div class="content-point-list">
                            <div class="content-point-media">
                                <img src="{{ asset('web/img/i1.png') }}" alt="imagees">
                            </div>
                            <div class="content-point-info">
                                <h3>Integrity</h3>
                                <p>
                                    We embrace and uphold the highest standards of personal and professional ethics, honesty
                                    and
                                    trust.
                                </p>
                            </div>
                        </div>
                        <div class="content-point-list">
                            <div class="content-point-media">
                                <img src="{{ asset('web/img/i2.png') }}" alt="imagees">
                            </div>
                            <div class="content-point-info">
                                <h3>Continuous Learning</h3>
                                <p>
                                    We focus on knowledge sharing for continuous improvement, learning and innovation.
                                </p>
                            </div>
                        </div>
                        <div class="content-point-list">
                            <div class="content-point-media">
                                <img src="{{ asset('web/img/i3.png') }}" alt="imagees">
                            </div>
                            <div class="content-point-info">
                                <h3>Quality</h3>
                                <p>
                                    We are empowered to deliver operational excellence through innovation and leadership
                                    skills.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 animate-true transition reach_section delay2"
                    data-animatetype="reach_section" data-delay="delay2">
                    <div class="content-section-wrap">
                        <span>What We Offer</span>
                        <h3>Do Business with us & Grow your Career</h3>
                        <p>
                            We are one of the top-performing employment company established to meet the overwhelming demands
                            of
                            Nepalese workforce abroad. It has tied-up with Malaysian, Qatar, UAE, Chinese and Saudi Arabian
                            investors who have extreme confidence on Overseas Nepalese Workers’ skills, attitude,
                            competence,
                            and determination.
                        </p>
                        <p>
                            In order to acquire our services please kindly send us your inquiry of interest. We shall revert
                            back immediately.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content Section End  -->

    <!-- Message  -->
    <section class="message mt">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 animate-true transition reach_section delay1" data-animatetype="reach_section"
                    data-delay="delay1">
                    <div class="message-media">
                        <div class="rolls">
                            <div class="roll"></div>
                            <div class="roll"></div>
                            <div class="roll"></div>
                            <div class="roll"></div>
                        </div>
                        <div class="rolls-img">
                            <img src="{{ @$webContent->chairman_profile ? url('/storage/public/uploads/chairman-image/' . @$webContent->chairman_profile) : asset('no-file.png') }}"
                                alt="images">
                        </div>
                    </div>
                    <h5 style="text-align: center;text-transform:uppercase">{{ @$webContent->chairman_name }}</h5>
                </div>
                <div class="col-lg-6 animate-true transition reach_section delay2" data-animatetype="reach_section"
                    data-delay="delay2">
                    <div class="message-info">
                        <span>Chairman Message</span>
                        <h3>Message From The Chairman</h3>
                        {!! @$webContent->chairman_message !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Message End  -->

    <!-- Services  -->
    <section class='service pt pb'>
        <div class='container'>
            <div class='main-title'>
                <h3>Service We <span> Provide</span></h3>
            </div>
            <div class='row'>

                @foreach ($services as $skey => $service)
                    <div class='col-lg-4 col-md-6 col-sm-12 animate-true transition reach_section delay{{ ++$skey }}'
                        data-animatetype='reach_section' data-delay='delay{{ $skey }}'>
                        <div class='service-wrap'>
                            <div class='service-img'>
                                <img src='{{ url('/storage/uploads/services/' . $service->image) }}'
                                    alt='service image'>
                            </div>
                            <div class='service-content'>
                                <h3>{{ $service->title }}</h3>
                                <p>
                                    {!! \Illuminate\Support\Str::limit($service->description, 150, $end = '...') !!}
                                </p>
                                <a href='{{ route('web.singleService', $service->slug) }}'>Read More <i
                                        class='las la-angle-double-right'></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Services End  -->

    <!-- About Section -->
    <section class='about-section pt pb'>
        <div class='container'>
            <div class='about-section-wrap'>
                <div class='about-section-col'>
                    <div class='row'>
                        <div class='col-md-6 col-sm-12 animate-true transition reach_section delay1'
                            data-animatetype='reach_section' data-delay='delay1'>
                            <div class='about-section-content'>
                                <span>Why Choose Us</span>
                                <h3>It's about Right People in the Right Place at the Right Time.</h3>
                                <p>
                                    Client satisfaction is our topmost priority. Therefore, whether you wish to develop a
                                    complex E-Commerce site, Entertainment site, Business Site, or Portfolio Site- the
                                    creative minds of Esolz Technologies.
                                </p>
                                <p>
                                    Techniques that specifically fit the
                                    best for your business and brings success to your online business in this digital world.
                                    In fact, we guarantee to give a seamless experience to the page visitors.
                                </p>
                                <div class="main-btn">
                                    <a href="{{ route('web.contactUs') }}">Contact Us <i class="las la-long-arrow-alt-right"></i></a>
                                </div>
                                <div class="short-info">
                                    <img src="{{ asset('assets/images/shape.png') }}" alt="images">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 animate-true transition reach_section delay3"
                            data-animatetype="reach_section" data-delay="delay3">
                            <div class="about-section-media">
                                <img src="{{ asset('web/img/slider1.jpg') }}" alt="images">
                            </div>
                        </div>
                    </div>
                </div>
                @if($latestNews)
                <div class="about-section-col">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 animate-true transition reach_section delay1"
                            data-animatetype="reach_section" data-delay="delay1">
                            <div class="about-section-content">
                                <span>Latest News & Update</span>
                                <h3>{{ $latestNews->title }}</h3>

                                {!! \Illuminate\Support\Str::limit($latestNews->content, 250, $end = '...') !!}

                                <div class="main-btn">
                                <a href="{{ route('web.newsDetails', $latestNews->slug) }}">Read More <i class="las la-long-arrow-alt-right"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 animate-true transition reach_section delay3"
                            data-animatetype="reach_section" data-delay="delay3">
                            <div class="about-section-media">
                                <img src="{{ asset('web/img/slider2.jpg') }}" alt="images">
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </section>
    <!-- About Section End  -->

    <!-- Why Choose  -->
    <section class="why-choose pt">
        <div class="container">
            <div class="main-title">
                <h3>Recuitment <span>Process</span></h3>
            </div>
            <div class="process-col">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 animate-true transition reach_section delay1"
                        data-animatetype="reach_section" data-delay="delay1">
                        <div class="why-choose-wrap">
                            <div class="borders bottom-borders" style="background-image:url('img/line.png');"></div>
                            <div class="why-choose-icon">
                                <img src="{{ asset('web/img/1.svg') }}" alt="images">
                                <span>01</span>
                            </div>
                            <div class="why-choose-content">
                                <h3>Requirement Gathering</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 animate-true transition reach_section delay2"
                        data-animatetype="reach_section" data-delay="delay2">
                        <div class="why-choose-wrap">
                            <div class="borders" style="background-image:url('img/line1.png');"></div>
                            <div class="why-choose-icon">
                                <img src="{{ asset('web/img/2.svg') }}" alt="images">
                                <span>02</span>
                            </div>
                            <div class="why-choose-content">
                                <h3>Plan & Deployment</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 animate-true transition reach_section delay3"
                        data-animatetype="reach_section" data-delay="delay3">
                        <div class="why-choose-wrap">
                            <div class="borders bottom-borders" style="background-image:url('img/line.png');"></div>
                            <div class="why-choose-icon">
                                <img src="{{ asset('web/img/3.svg') }}" alt="images">
                                <span>03</span>
                            </div>
                            <div class="why-choose-content">
                                <h3>Quality Assurance</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 animate-true transition reach_section delay4"
                        data-animatetype="reach_section" data-delay="delay4">
                        <div class="why-choose-wrap">
                            <div class="why-choose-icon">
                                <img src="{{ asset('web/img/4.svg') }}" alt="images">
                                <span>04</span>
                            </div>
                            <div class="why-choose-content">
                                <h3>Finalise Process</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Choose End  -->

    <!-- Information  -->
    <section class="information mt pb">
        <div class="container">
            <div class="main-title">
                <h3>Our <span>Media</span></h3>
            </div>
            <div class="portfolio">
                @foreach ($medias as $mKey => $media)
                    <div class="item">
                        <a href="javascript::void(0)">
                            <img src="{{ url('/storage/uploads/gallery-images/' . $media->filename) }}" alt="Media Image">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="testimonials">
                <div class="testimonials-wrap">
                    <div class="testimonials-title">
                        <h3><img src="{{ asset('web/img/star.png') }}" alt="images"> Testimonials</h3>
                        @php
                            $allTestimonials = \App\Models\Testimonials::count();
                        @endphp
                        @if($allTestimonials > 0)
                            <span>4.5 of 5 ({{ $allTestimonials }} reviews)</span>
                            <div class="rating">
                                <img src="{{ asset('web/img/rating.webp') }}" alt="images">
                            </div>
                            <p>Company average: 4.5</p>
                        @endif
                    </div>
                    <div class="testimonials-list">
                        <div id="testimonials">
                            @foreach ($testimonials as $tKey => $testi)
                            <div class="item animate-true transition reach_section delay{{ ++$tKey }}"
                                data-animatetype="reach_section" data-delay="delay{{ $tKey }}">
                                <div class="testimonials-card">
                                    <div class="testimonials-info">
                                        <p>
                                            {!! $testi->message !!}
                                        </p>
                                        <div class="testimonials-profile">
                                            <img src="{{ url('storage/uploads/testimonial-images/'.$testi->image) }}" alt="images">
                                            <div class="testimonials-profile-info">
                                                <h3>{{ $testi->name }}</h3>
                                                <span>{{ $testi->designation }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Information End  -->

    <!-- Blog  -->
    {{-- <section class="blog mt mb">
    <div class="container">
        <div class="main-title">
            <h3>Latest <span>Blogs</span></h3>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 animate-true transition reach_section delay1"
                data-animatetype="reach_section" data-delay="delay1">
                <div class="blog-wrap">
                    <div class="blog-media">
                        <a href="#"><img src="{{ asset('web/img/slider1.jpg') }}" alt="images"></a>
                    </div>
                    <div class="blog-content">
                        <span>September 23, 2022</span>
                        <h3><a href="#">Our Company is committed to help clients to reach the goals</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 animate-true transition reach_section delay2"
                data-animatetype="reach_section" data-delay="delay2">
                <div class="blog-wrap">
                    <div class="blog-media">
                        <a href="#"><img src="{{ asset('web/img/slider2.jpg') }}" alt="images"></a>
                    </div>
                    <div class="blog-content">
                        <span>September 24, 2022</span>
                        <h3><a href="#">It's about Right People in the Right Place at the Right Time</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class='col-lg-4 col-md-6 col-sm-12 animate-true transition reach_section delay3'
                data-animatetype='reach_section' data-delay='delay3'>
                <div class='blog-wrap'>
                    <div class='blog-media'>
                        <a href='#'><img src='{{ asset('web/img/slider3.jpg') }}' alt='images'></a>
                    </div>
                    <div class='blog-content'>
                        <span>September 25, 2022</span>
                        <h3><a href='#'>We are the top-performing employment company </a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
    <!-- Blog End  -->

    <!-- Partners  -->
    <section class='partners'>
        <div class='container'>
            <div class="main-title">
                <h3>Our <span>Clients</span></h3>
            </div>
            <div id='partners'>
                @foreach ($workingCompanies as $ckey => $company)
                    <div class='item animate-true transition reach_section delay{{ ++$ckey }}'
                        data-animatetype='reach_section' data-delay='delay{{ $ckey }}'>
                        <img src='{{ url('/storage/uploads/company-logo/' . $company->logo) }}'  title="{{ $company->name }}" alt='logo'>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Partners End  -->
@endsection
