@extends('frontend.layout')

@section('title')
    Privacy Policy | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/' . @$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>Privacy Policy</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->


    <!-- General Page  -->
    <div class="general-page mt mb">
        <div class="container">
            <div class="general-page-wrap">
                {!! @$setting->privacy_and_policy !!}
            </div>
        </div>
    </div>
    <!-- General Page End  -->
@endsection
