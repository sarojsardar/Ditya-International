@if(@$candidate->documentProcess)
    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-12">
        <h6>Profile</h6>
        <hr>
    </div>
    <div class="col-lg-6">
        @if (@$candidate->profile)
            <img src='{{ url('/storage/public/uploads/candidate-profiles/'.@$candidate->profile) }}' alt='profile image' style='height: 5rem;width: auto;'>
            <a href="{{ route('download.candidateProfile', @$candidate->profile) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @else
            <img src='{{ asset('no-profile.jpg') }}' alt='profile image' style='height: 5rem;width: auto;'>
        @endif
    </div>
    <div class="col-12 mt-4">
        <h6>Passport Details</h6>
        <hr>
    </div>
    <div class="col-lg-6">
        <p><span><strong>Passport Number:</strong> {{ @$candidate->passportDetails->passport_no }}</span></p>
        <p><span><strong>Passport Issue Date:</strong> {{ @$candidate->passportDetails->passport_issue_date }}</span></p>
        <p><span><strong>Passport Expiry Date:</strong> {{ @$candidate->passportDetails->passport_expiry_date }}</span></p>
        <p><span><strong>Birth Place:</strong> {{ @$candidate->passportDetails->place_of_birth }}</span></p>
        <p><span><strong>Passport Self:</strong> {{ @$candidate->documentProcess->passportSelf->name }}</span></p>
    </div>
    <div class="col-lg-6">
        <label for="">Passport Image</label>
        <br>
        @foreach (explode(',', @$candidate->passportDetails->passport_images) as $img)
        @if(pathinfo(public_path('storage/public/uploads/passport-images/'.$img), PATHINFO_EXTENSION) == 'pdf')
            <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
            <a href="{{ route('download.downloadPassportImage', $img) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @else
            <img src="{{ url('/storage/public/uploads/passport-images/'.$img) }}" alt="" style="height: 10rem;with: auto">
            <a href="{{ route('download.downloadPassportImage', $img) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @endif
        @endforeach
    </div>
    @if(@$candidate->additional_documents)
        <div class="col-12 mt-4">
            <h6>Additional Documents</h6>
            <hr>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="">Documents</label>
                <br>
                @php
                    $addtionalDocs = explode(',', @$candidate->additional_documents);
                @endphp
                @foreach ($addtionalDocs as $aImg)
                    @if(pathinfo(public_path('storage/public/uploads/additional-documents/'.$aImg), PATHINFO_EXTENSION) == 'pdf')
                        <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
                        <a href="{{ route('download.downloadCandidateAdditionalDoc', $aImg) }}" target="_blank" style="color: rgb(102, 102, 238)" title="{{ $aImg }}"><i class="lar la-save"></i> Download</a>
                    @else
                        <img src="{{ url('/storage/public/uploads/additional-documents/'.$aImg) }}" alt="" style="height: 5rem;with: auto">
                        <a href="{{ route('download.downloadCandidateAdditionalDoc', $aImg) }}" target="_blank" style="color: rgb(102, 102, 238)" title="{{ $aImg }}"><i class="lar la-save"></i> Download</a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <br>
    <br>
    <div class="col-12">
        <h6>Medical Document</h6>
        <hr>
    </div>
    <div class="col-lg-12">
        @if(pathinfo(public_path('storage/public/uploads/candidate-medical-reports/'.@$candidate->documentProcess->medical_file), PATHINFO_EXTENSION) == 'pdf')
        <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
        <a href="{{ route('download.downloadMedicalReport', @$candidate->documentProcess->id) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @else
        <img src="{{ url('/storage/public/uploads/candidate-medical-reports/'.@$candidate->documentProcess->medical_file) }}" alt="" style="height: 10rem;with: auto">
        <a href="{{ route('download.downloadMedicalReport', @$candidate->documentProcess->id) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @endif
        <p><span><strong>Expiry Date:</strong> {{ \Carbon\Carbon::parse(@$candidate->documentProcess->medical_expiry)->format('Y , d M') }}</span></p>
    </div>
    <div class="col-12">
        <h6>QR</h6>
        <hr>
    </div>
    <div class="col-lg-12">
        <img src="{{ url('/storage/public/uploads/candidate-qr/'.@$candidate->documentProcess->qr) }}" alt="" style="height: 10rem;with: auto">
        <a href="{{ route('download.downloadQr', @$candidate->documentProcess->qr) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
    </div>
    <br>
    <br>

    @if(@$candidate->documentProcess->visa)
    <div class="col-12">
        <h6>Visa Details</h6>
        <hr>
    </div>
    <div class="col-lg-12">
        @if(pathinfo(public_path('/storage/public/uploads/candidate-visas/'.@$candidate->documentProcess->visa), PATHINFO_EXTENSION) == 'pdf')
            <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
            <a href="{{ route('download.downloadVisaImage', @$candidate->documentProcess->visa) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @else
            <img src="{{ url('/storage/public/uploads/candidate-visas/'.@$candidate->documentProcess->visa) }}" alt="" style="height: 10rem;with: auto">
            <a href="{{ route('download.downloadVisaImage', @$candidate->documentProcess->visa) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @endif
    </div>
    <br>
    <br>
    @endif
    @if(@$candidate->documentProcess->ticket)
    <div class="col-12">
        <h6>Flight Details</h6>
        <hr>
    </div>
    <div class="col-lg-6">
        <p><span><strong>Flight Date:</strong> {{ \Carbon\Carbon::parse(@$candidate->documentProcess->flight_date)->format('Y , d M | g:i A') }}</span></p>
    </div>
    <div class="col-lg-6">
        @if(pathinfo(public_path('/storage/public/uploads/candidate-tickets/'.@$candidate->documentProcess->ticket), PATHINFO_EXTENSION) == 'pdf')
        <img src='{{ asset('pdf-logo.jpg')}}' alt='ticket' style='height: 5rem;width: auto;'>
        <a href="{{ route('download.downloadMedicalReport', @$candidate->documentProcess->id) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @else
        <img src="{{ url('/storage/public/uploads/candidate-tickets/'.@$candidate->documentProcess->ticket) }}" alt="" style="height: 10rem;with: auto">
        <a href="{{ route('download.downloadMedicalReport', @$candidate->documentProcess->id) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @endif
    </div>
    @endif
</div>

@else

<div class="row">
    <div class="col-12">
        <h6>Profile</h6>
        <hr>
    </div>
    <div class="col-lg-6">
        @if (@$candidate->profile)
            <img src='{{ url('/storage/public/uploads/candidate-profiles/'.@$candidate->profile) }}' alt='profile image' style='height: 5rem;width: auto;'>
            <a href="{{ route('download.candidateProfile', @$candidate->profile) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
        @else
            <img src='{{ asset('no-profile.jpg') }}' alt='profile image' style='height: 5rem;width: auto;'>
        @endif
    </div>
    <div class="col-12">
        <h6>Passport Details</h6>
        <hr>
    </div>
    <div class="col-lg-6">
        <p><span><strong>Passport Number:</strong> {{ @$candidate->passportDetails->passport_no }}</span></p>
        <p><span><strong>Passport Issue Date:</strong> {{ @$candidate->passportDetails->passport_issue_date }}</span></p>
        <p><span><strong>Passport Expiry Date:</strong> {{ @$candidate->passportDetails->passport_expiry_date }}</span></p>
        <p><span><strong>Birth Place:</strong> {{ @$candidate->passportDetails->place_of_birth }}</span></p>
        <p><span><strong>Passport Self:</strong> {{ @$candidate->documentProcess->passportSelf->name }}</span></p>
    </div>
    <div class="col-lg-6">
        <label for="">Passport Image</label>
        <br>
        @if(@$candidate->passportDetails->passport_images)
            @foreach (explode(',', $candidate->passportDetails->passport_images) as $img)
            @if(pathinfo(public_path('storage/public/uploads/passport-images/'.$img), PATHINFO_EXTENSION) == 'pdf')
                <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
                <a href="{{ route('download.downloadPassportImage', $img) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
            @else
                <img src="{{ url('/storage/public/uploads/passport-images/'.$img) }}" alt="" style="height: 10rem;with: auto">
                <a href="{{ route('download.downloadPassportImage', $img) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
            @endif
            @endforeach
        @else
        <img src="{{ asset('no-file.png') }}" alt="" style="height: 10rem;with: auto">
        @endif
    </div>

    @if(@$candidate->additional_documents)
        <div class="col-12 mt-4">
            <h6>Additional Documents</h6>
            <hr>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="">Documents</label>
                <br>
                @php
                    $addtionalDocs = explode(',', @$candidate->additional_documents);
                @endphp
                @foreach ($addtionalDocs as $aImg)
                    @if(pathinfo(public_path('storage/public/uploads/additional-documents/'.$aImg), PATHINFO_EXTENSION) == 'pdf')
                        <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
                        <a href="{{ route('download.downloadCandidateAdditionalDoc', $aImg) }}" target="_blank" style="color: rgb(102, 102, 238)" title="{{ $aImg }}"><i class="lar la-save"></i> Download</a>
                    @else
                        <img src="{{ url('/storage/public/uploads/additional-documents/'.$aImg) }}" alt="" style="height: 5rem;with: auto">
                        <a href="{{ route('download.downloadCandidateAdditionalDoc', $aImg) }}" target="_blank" style="color: rgb(102, 102, 238)" title="{{ $aImg }}"><i class="lar la-save"></i> Download</a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>
@endif
