@extends('frontend.layout')

@section('title')
   News | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/' . @$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>News</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.news') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">News</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->

    <!-- News Page  -->
    <section class="news-page mt mb">
        <div class="container">
            <div class="row">
                @foreach ($news as $new)  
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="news-wrap">
                        <div class="news-images">
                            <a href="{{ route('web.newsDetails', $new->slug) }}">
                                <img src="{{ url('storage/public/uploads/news-images/'.$new->thumbnail)}}" alt="images">
                            </a>
                        </div>
                        <div class="news-content">
                            <h3><a href="{{ route('web.newsDetails', $new->slug) }}">{{ $new->title }}</a></h3>
                            <div class="news-meta">
                                <ul>
                                    <li><i class="las la-user"></i> Ditya International</li>
                                    <li><i class="las la-calendar-check"></i>{{ \Carbon\Carbon::parse($new->created_at)->format('d M, Y') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- News Page End  -->


@endsection
