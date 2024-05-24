@extends('frontend.layout')

@section('title')
{{ $service->title }} | {{ config('app.name') }}
@endsection

@section('content')


<!-- Services Page  -->
<section class="services-details mt mb">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="service-details-main">
                    <div class="service-featured-images">
                        {{-- <img src="img/banner4.jpg" alt="images"> --}}
                    </div>
                    <h2>{{ $service->title }}</h2>
                    {!! $service->description !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="service-sidebar">
                    <h3>Related Services</h3>
                    <ul>
                        @foreach ($otherServices as $oService)                            
                            <li><a href="{{ route('web.singleService', $oService->slug) }}">{{ $oService->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Page End  -->

@endsection