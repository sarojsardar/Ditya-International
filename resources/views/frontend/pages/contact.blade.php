@extends('frontend.layout')

@section('title')
Contact Us | {{ config('app.name') }}
@endsection
@section('content')
<!-- Banner  -->
<section class="page-banner" style="background-image:url('{{ asset('web/img/slider1.jpg') }}');">
    <div class="container">
        <div class="page-banner-wrap">
            <h1>Contact Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Banner End  -->

<!-- Contact Page  -->
<section class="contact-page mt">
    <div class="container">
        <div class="page-title">
            <h3>If need any info please contact us!</h3>
            <p>
                We’re glad to discuss your situation. So please contact us via the details below, or
                enter your request.
            </p>
        </div>
        <div class="row m-0">
            <div class="col-md-4 p-0">
                <div class="contact-details">
                    <ul>
                        <li>
                            <i class="las la-street-view"></i>
                            <div class="contact-details-info">
                                <span>Address</span>
                                <p>{{ @$setting->location }}</p>
                            </div>
                        </li>
                        <li>
                            <i class="las la-phone-volume"></i>
                            <div class="contact-details-info">
                                <span>Phone</span>
                                <p>{{ @$setting->contact }}</p>
                            </div>
                        </li>
                        <li>
                            <i class="las la-envelope-open-text"></i>
                            <div class="contact-details-info">
                                <span>Email</span>
                                <p>{{ @$setting->official_email }}</p>
                            </div>
                        </li>
                        <li>
                            <i class="las la-globe"></i>
                            <div class="contact-details-info">
                                <span>Website</span>
                                <p>www.dityainternational.com</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 p-0">
                <div class="contact-form">
                    <form action="{{ route('client.storeClientMessage') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Full Name</label>
                                    <input type="text" name="name" class="form-control">
                                    @if($errors->has('name'))
                                        <ul class=""><li style="color: rgb(214, 59, 59);font-size:12px">{{ $errors->first('name') }}</li></ul>
                                    @endif      
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control">
                                    @if($errors->has('email'))
                                        <ul class=""><li style="color: rgb(214, 59, 59);font-size:12px">{{ $errors->first('email') }}</li></ul>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" name="contact" class="form-control">
                                    @if($errors->has('contact'))
                                        <ul class=""><li style="color: rgb(214, 59, 59);font-size:12px">{{ $errors->first('contact') }}</li></ul>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <input type="text" name="subject" class="form-control">
                                    @if($errors->has('subject'))
                                        <ul class=""><li style="color: rgb(214, 59, 59);font-size:12px">{{ $errors->first('subject') }}</li></ul>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Message</label>
                                    <textarea name="message" class="form-control"></textarea>
                                    @if($errors->has('message'))
                                        <ul class=""><li style="color: rgb(214, 59, 59);font-size:12px">{{ $errors->first('message') }}</li></ul>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="map">
        {!! @$setting->map !!}
    </div>
</section>
@endsection
