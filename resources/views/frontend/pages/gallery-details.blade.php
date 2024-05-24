@extends('frontend.layout')

@section('title')
    Gallery {{ $galleryCategory->category_name }} | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/' . @$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>Gallery</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.gallery') }}">Gallery</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $galleryCategory->category_name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->

    <!-- Gallery Page  -->
    <section class="gallery-details-page mt mb">
        <div class="container">
            <ul id="lightgallery">
                @foreach ($galleryCategory->images as $gImg)
                <li data-src="{{ url('/storage/public/uploads/gallery-images/'.$gImg->filename) }}">
                    <img src="{{ url('/storage/public/uploads/gallery-images/'.$gImg->filename) }}" alt="{{ $gImg->filename }}">
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    <!-- Gallery Page End  -->
@endsection
