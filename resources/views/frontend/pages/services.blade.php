@extends('frontend.layout')

@section('title')
Our Services | {{ config('app.name') }}
@endsection
@section('content')
<!-- Banner  -->
<section class="page-banner" style="background-image:url('{{ asset('web/img/slider1.jpg') }}');">
    <div class="container">
        <div class="page-banner-wrap">
            <h1>Our Services</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Banner End  -->


<!-- Services Page  -->
<section class="service-page mt mb">
    <div class='container'>
        <div class='row'>
            @foreach ($services as $key => $service)
                <div class='col-lg-4 col-md-6 col-sm-12 animate-true transition reach_section delay{{ ++$key }}'
                    data-animatetype='reach_section' data-delay='delay{{ $key }}'>
                    <div class='service-wrap'>
                        <div class='service-img'>
                            <img src='{{ url('/storage/public/uploads/services/'.$service->image) }}' alt='images'>
                        </div>
                        <div class='service-content'>
                            <h3>{{ $service->title }}</h3>
                            <p>
                                {!! \Illuminate\Support\Str::limit($service->description, 150, $end='...') !!}
                            </p>
                            <a href='{{ route('web.singleService', $service->slug) }}'>Read More <i class='las la-angle-double-right'></i></a>
                        </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Services Page End  -->
@endsection
