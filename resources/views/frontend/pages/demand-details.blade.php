@extends('frontend.layout')

@section('title')
    Demand Details | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/' . @$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>Demand Details</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $demand->demand_code }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->

    <!-- Demand Details  -->
    <section class="demand-details mt mb">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="demand-details-list">
                        <h3>Company Details</h3>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $demand->company->name }}</td>
                                </tr>
                                <tr>
                                    <th>Country:</th>
                                    <td>{{ $demand->company->originCountry->code.' | '.$demand->company->originCountry->name }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $demand->company->address }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $demand->company->user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="company-media">
                            <span>Company Logo</span>
                            <img src="{{ url('/storage/public/uploads/company-logo/'.$demand->company->logo) }}" style="height: 80px;width:auto" alt="{{ $demand->company->name }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="demand-details-list">
                        <h3>Demand Details</h3>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Quota Value:</th>
                                    <td>{{ $demand->quota_value }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="demand-media">
                            <span>Demand Letters</span>
                            @php
                                $letters = explode(',', $demand->demand_letter);
                            @endphp
                            @foreach ($letters as $letter)
                            @if (pathinfo(public_path('storage/public/uploads/company-demand-letters/' . $letter), PATHINFO_EXTENSION) == 'pdf')
                                <img src='{{ asset('web/img/pdf.png') }}' alt='Medical report image'
                                    style='height: 5rem;width: auto;'>
                                    <div class="down-btn">
                                        <a href="{{ route('web.downloadDemand', $letter) }}"
                                            target="_blank" title="{{ $letter }}"><i
                                                class="lar la-save"></i> Download</a>
                                    </div>
                            @else
                                <img src="{{ url('/storage/public/uploads/company-demand-letters/' . $letter) }}"
                                    alt="" style="height: 5rem;with: auto">
                                    <div class="down-btn">
                                        <a href="{{ route('web.downloadDemand', $letter) }}"
                                            target="_blank" title="{{ $letter }}"><i
                                                class="lar la-save"></i> Download</a>
                                    </div>
                            @endif
                            @endforeach                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Demand Details End  -->
@endsection
