@extends('frontend.layout')

@section('title')
    News Details | {{ config('app.name') }}
@endsection
@section('content')
    <!-- News Page  -->
    <section class="news-details mt mb">
        <div class="container">
            <div class="news-details-wrap">
                <div class="featured-img">
                    <img src="{{ url('storage/public/uploads/news-images/'.$singleNews->thumbnail)}}" alt="images">
                </div>
                <div class="news-meta">
                    <ul>
                        <li><i class="las la-user"></i> Ditya International</li>
                        <li><i class="las la-calendar-check"></i> {{ \Carbon\Carbon::parse($singleNews->created_at)->format('d M, Y') }}</li>
                    </ul>
                </div>
                <h2>{{ $singleNews->title }}</h2>
                {!! $singleNews->content !!}
                <!-- Related News  -->
                <div class="related-news mb">
                    <div class="main-title">
                        <h3>Related <span>News</span></h3>
                    </div>
                    <div class="row">
                        @foreach ($relatedNews as $rNews) 
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="news-wrap">
                                    <div class="news-images">
                                        <a href="{{ route('web.newsDetails', $rNews->slug) }}">
                                            <img src="{{ url('storage/public/uploads/news-images/'.$rNews->thumbnail)}}" alt="images">
                                        </a>
                                    </div>
                                    <div class="news-content">
                                        <h3><a href="{{ route('web.newsDetails', $rNews->slug) }}">{{ $rNews->title }}</a>
                                        </h3>
                                        <div class="news-meta">
                                            <ul>
                                                <li><i class="las la-user"></i> Ditya International</li>
                                                <li><i class="las la-calendar-check"></i> {{ \Carbon\Carbon::parse($rNews->created_at)->format('d M, Y') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Related News End  -->
            </div>
        </div>
    </section>
    <!-- News Page End  -->
@endsection
