@extends('frontend.layout')

@section('title')
    Vacancies | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/' . @$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>Vaccancy</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vacancies</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->


    <!-- General Page  -->
    <div class="vaccancy-page mt mb">
        <div class="container">
            <div class="vaccancy-wrap">
                <h2>List of Available Vacancies</h2>
                <div class="table-responsive">
                    <table class="table-bordered">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Demand Code</th>
                                <th>Company</th>
                                <th>Company Logo</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($availableDemands as $key => $demand)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $demand->demand_code }}</td>
                                    <td>{{ $demand->company->name }}</td>
                                    <td>
                                        <img src="{{ url('/storage/public/uploads/company-logo/'.$demand->company->logo) }}" style="height: 80px;width:auto" alt="{{ $demand->company->name }}">
                                    </td>
                                    <td>{{ $demand->company->originCountry->code }} | {{ $demand->company->originCountry->name }}</td>
                                    <td>
                                        <a href="{{ route('web.demandDetails', $demand->demand_code) }}"><button class="btn" style="display: block;
                                            background: transparent;
                                            font-size: 12px;
                                            font-weight: 500;
                                            padding: 10px 15px;
                                            line-height: normal;
                                            border-radius: 50px;
                                            background: rgba(0, 72, 137, 0.9);
                                            border: none;color: white">View Details</button></a>
                                    </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    <!-- General Page End  -->
@endsection
