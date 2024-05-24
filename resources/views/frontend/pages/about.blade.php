@extends('frontend.layout')

@section('title')
About Us | {{ config('app.name') }}
@endsection
@section('content')

<!-- Banner  -->
<section class="page-banner" style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/'.@$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
    <div class="container">
        <div class="page-banner-wrap">
            <h1>About Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Banner End  -->

<!-- About Us Page  -->
<section class="about-us-page mt mb">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-us-content">
                    <span>About Us</span>
                    <h3>{{ @$webContent->about_us_title }}</h3>
                    {!! @$webContent->about_us_content !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-us-media">
                    <img src="{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/'.@$webContent->about_us_side_banner) : asset('web/img/about.jpg') }}" alt="images">
                    @php
                        $thisYear = \Carbon\Carbon::today();
                        $toDate = \Carbon\Carbon::parse("2018-01-01");
                        $fromDate = \Carbon\Carbon::parse($thisYear);
                
                        $years = $toDate->diffInYears($fromDate);
                    @endphp
                    <span>{{ $years }} Years of Experience</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Page End  -->
@endsection