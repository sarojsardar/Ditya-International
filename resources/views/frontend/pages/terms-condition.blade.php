@extends('frontend.layout')

@section('title')
Terms & Conditions | {{ config('app.name') }}
@endsection
@section('content')
<!-- Banner  -->
<section class="page-banner" style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/'.@$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
    <div class="container">
        <div class="page-banner-wrap">
            <h1>Terms & Conditions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="contact-page mt">
    <div class="container">
        <div class="row m-0">
            <div class="col-12">
                {!! @$setting->terms_and_condition !!}
            </div>
        </div>
    </div>
</section>

@endsection