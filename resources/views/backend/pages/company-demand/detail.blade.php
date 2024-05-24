@extends('backend.layout')

@section('title')
Demand Details | {{ config('app.name') }}
@endsection

@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-color">
                Company Details
            </div>
            <div class="card-body">
                <div class="logo-holder">
                    <img src="{{ url('/storage/public/uploads/company-logo/'.$demand->company->logo) }}" alt="">
                </div>
                <p><span><strong>Name:</strong> {{ ucfirst($demand->company->name) }}</span></p>
                <p><span><strong>Country:</strong> {{ ucfirst($demand->company->originCountry->name) }}</span></p>
                <p><span><strong>Address:</strong> {{ ucfirst($demand->company->address) }}</span></p>
                <p><span><strong>Email:</strong> {{ ucfirst($demand->company->user->email) }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-color">
                Demand Details
            </div>
            <div class="card-body">
                @php
                    $quota = (new \App\Enum\DemandQuotaTypes())->getSingleValue($demand->quota)
                @endphp
                <p><span><strong>Quota:</strong> {{ $quota }}</span></p>
                <p><span><strong>Quota Value:</strong> {{ ucfirst($demand->quota_value) }}</span></p>
                <p><span><strong>Remaining Value:</strong> {{ ucfirst($demand->remaining_quota) }}</span></p>
                @role(['Company'])
                @else
                <p><span><strong>Office Rate:</strong> Rs. {{ number_format($demand->office_rate) }}</span></p>
                @endrole
                <p><span><strong>Demand Letters:</strong></span></p>

                @php
                    $letters = explode(',', @$demand->demand_letter)
                @endphp
                @foreach ($letters as $letter)
                    @if (pathinfo(public_path('storage/public/uploads/company-demand-letters/' . $letter), PATHINFO_EXTENSION) == 'pdf')
                        <img src='{{ asset('pdf-logo.jpg') }}' alt='Medical report image'
                            style='height: 5rem;width: auto;'>
                        <a href="{{ route('download.download-demand', $letter) }}"
                            target="_blank" style="color: rgb(102, 102, 238)" title="{{ $letter }}"><i
                                class="lar la-save"></i> Download</a>
                                <hr>
                    @else
                    <img src='{{ url('/storage/public/uploads/company-demand-letters/'.$letter)}}' alt='company logo' style='margin-bottom:10px;'>
                        <a href="{{ route('download.download-demand', $letter) }}"
                            target="_blank" style="color: rgb(102, 102, 238)" title="{{ $letter }}"><i
                                class="lar la-save"></i> Download</a>
                                <hr>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>

    </script>
@endpush
