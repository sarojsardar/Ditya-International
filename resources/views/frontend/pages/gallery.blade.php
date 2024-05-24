@extends('frontend.layout')

@section('title')
   Gallery | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ asset('web/img/slider2.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>Gallery</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Galleries</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->

    <!-- Gallery Page  -->
    <section class="gallery-page mt mb">
        <div class="container">
            <div class="row">

                @foreach ($galleryCategories as $cat)      
                <div class="col-lg-3">
                    <div class="gallery-wrap">
                        <div class="gallery-img">
                            <a href="{{ route('web.galleryDetails', $cat->slug) }}">
                                <img src="{{ url('/storage/public/uploads/category-images/'.$cat->thumbnail) }}" alt="{{ $cat->category_name }}">
                            </a>
                        </div>
                        <div class="gallery-content">
                            <h3><a href="{{ route('web.galleryDetails', $cat->slug) }}">{{ $cat->category_name }} <span>({{ count($cat->images) }})</span></a></h3>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
    <!-- Gallery Page End  -->


@endsection
