@extends('backend.layout')

@section('title')
Candidate Document Upload Center | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-color">
                Edit Uploaded Additional Documents of <span style="font-size: 16px">{{ $candidate->first_name.' '.$candidate->middle_name.' '.$candidate->last_name }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('document-process.uploadDocument', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="{{ @$candidate->profile }}" name="old_profile">
                    <input type="hidden" value="{{ @$candidate->documentProcess->qr }}" name="old_qr">
                    <input type="hidden" value="{{ @$candidate->passportDetails->passport_images }}" name="old_passport">
                    <div class="row">
                        <div class="col-12">
                            <h6>Personal Information</h6>
                            <hr>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Profile @if(!$candidate->profile)<span style="color: rgb(241, 69, 69)">*</span>@endif</label>
                                <input class="form-control-file" onchange="setDisplayImage(event);" type="file" name="profile_picture" value="{{ old('profile_picture', @$candidate->profile) }}" accept="image/png, image/gif, image/jpeg" @if(!$candidate->profile) required @endif>
                                @if($errors->has('profile_picture'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('profile_picture') }}</li></ul>
                                @endif
                                <div id="holder" style="margin-top:15px;max-height:100px;">
                                    @if (@$candidate->profile)
                                        <img src='{{ url('/storage/public/uploads/candidate-profiles/'.@$candidate->profile) }}' alt='profile image' style='height: 5rem;width: auto;'>
                                    @else
                                        <img src='{{ asset('no-profile.jpg') }}' alt='profile image' style='height: 5rem;width: auto;'>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h6>Passport Detail</h6>
                            <hr>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Passport Number <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input type="text" name="passport_no" class="form-control" value="{{ old('passport_no', @$candidate->passportDetails->passport_no) }}" required>
                                @if($errors->has('passport_no'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('passport_no') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Issue Date <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input type="date" name="date_of_issue" class="form-control" value="{{ old('date_of_issue', @$candidate->passportDetails->passport_issue_date) }}" required>
                                @if($errors->has('date_of_issue'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('date_of_issue') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Expiry Date <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input type="date" name="date_of_expiry" class="form-control" value="{{ old('date_of_expiry', @$candidate->passportDetails->passport_expiry_date) }}" required>
                                @if($errors->has('date_of_expiry'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('date_of_expiry') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Birth Place <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', @$candidate->passportDetails->place_of_birth) }}" required>
                                @if($errors->has('birth_place'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('birth_place') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Passport Images [Can be Multiple] @if(!@$candidate->passportDetails->passport_images)<span style="color: rgb(241, 69, 69)">*</span>@endif</label>
                                <input class="form-control-file" onchange="setDisplayPassportImage(event);" type="file" name="passport_images[]" value="{{ old('passport_images', @$candidate->passportDetails->passport_images) }}" multiple accept="image/*, .pdf" @if(!@$candidate->passportDetails->passport_images) required @endif>
                                @if($errors->has('passport_images'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('passport_images') }}</li></ul>
                                @endif
                                @if($errors->has('passport_images.0'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('passport_images.0') }}</li></ul>
                                @endif
                                <div id="passport-holder" style="margin-top:15px;max-height:100px;">
                                    @if (@$candidate->passportDetails->passport_images)
                                    @php
                                        $images = explode(',', @$candidate->passportDetails->passport_images);
                                    @endphp
                                    @foreach ($images as $pImg)
                                    <img src='{{ url('/storage/public/uploads/passport-images/'.$pImg) }}' alt='passport images' style='height: 5rem;width: auto;'>
                                    @endforeach
                                    @else
                                    <img src='{{ asset('no-file.png') }}' alt='' style='height: 5rem;width: auto;'>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h6>Medical Document</h6>
                            <hr>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Medical Report</label>
                                @if($errors->has('medical_report'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('medical_report') }}</li></ul>
                                @endif
                                <div id="report-holder" style="margin-top:15px;max-height:100px;">
                                    @if (@$candidate->documentProcess->medical_file)
                                    @if (pathinfo(url('/storage/public/uploads/candidate-medical-reports/'.$candidate->documentProcess->medical_file), PATHINFO_EXTENSION) == 'pdf')
                                        <img src='{{ asset('pdf-logo.jpg')}}' alt='Medical report image' style='height: 5rem;width: auto;'>
                                        <a href="{{ route('download.downloadMedicalReport', $candidate->documentProcess->id) }}" target="_blank" style="color: rgb(102, 102, 238)" title="Download file"><i class="lar la-save"></i> Download</a>
                                    @else
                                        <img src='{{ url('/storage/public/uploads/candidate-medical-reports/'.@$candidate->documentProcess->medical_file) }}' alt='Medical report image' style='height: 5rem;width: auto;'>
                                    @endif
                                    @else
                                        <img src='{{ asset('no-file.png') }}' alt='medical report image' style='height: 5rem;width: auto;'>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Expiry Date</label>
                                <input type="date" name="medical_expiry" class="form-control" value="{{ old('medical_expiry', @$candidate->documentProcess->medical_expiry) }}" readonly>
                                @if($errors->has('medical_expiry'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('medical_expiry') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h6>QR</h6>
                            <hr>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">QR File</label>
                                <input type="file" name="qr" onchange="setQrImage(event);" class="form-control-file" accept="image/png, image/gif, image/jpeg" required>
                                @if($errors->has('qr'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('qr') }}</li></ul>
                                @endif
                                <div id="qr-holder" style="margin-top:15px;max-height:100px;">
                                    @if (@$candidate->documentProcess->qr)
                                        <img src='{{ url('/storage/public/uploads/candidate-qr/'.@$candidate->documentProcess->qr) }}' alt='Medical qr image' style='height: 5rem;width: auto;'>
                                    @else
                                        <img src='{{ asset('no-file.png') }}' alt='medical qr image' style='height: 5rem;width: auto;'>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h6>Passport Self</h6>
                            <hr>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Passport Self <span style="color: rgb(241, 69, 69)">*</span></label>
                                <select name="passport_self" class="form-control select2-options" required>
                                    <option value="">== Choose Company ==</option>
                                    @foreach ($selves as $self)
                                        <option value="{{ $self->id }}" @if($self->id == old('passport_self') || $self->id == @$candidate->documentProcess->passport_self) selected @endif>{{ ucfirst($self->name) }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('passport_self'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('passport_self') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit Document</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        function setDisplayImage(event){
            var file = event.target.files;
            $('#holder').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#holder').append("<img src='"+url+"' alt='profile image' style='height: 80px;width: auto;'>")
            }
        }

        function setMedicalImage(event){
            var file = event.target.files;
            $('#report-holder').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#report-holder').append("<img src='"+url+"' alt='medical image' style='height: 80px;width: auto;'>")
            }
        }

        function setQrImage(event){
            var file = event.target.files;
            $('#qr-holder').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#qr-holder').append("<img src='"+url+"' alt='qr image' style='height: 80px;width: auto;'>")
            }
        }

        function setDisplayPassportImage(event){
            var file = event.target.files;
            $('#passport-holder').empty();
            for(i=0;i<file.length;i++){
                if(file[i].name.split('.').pop() == 'pdf'){
                    let url = '{{ URL::asset('pdf-logo.jpg') }}'
                    $('#passport-holder').append("<img src='"+url+"' alt='medical image' style='height: 80px;width: auto;'>")

                }else{
                    let url = URL.createObjectURL(file[i]);
                    $('#passport-holder').append("<img src='"+url+"' alt='medical image' style='height: 80px;width: auto;'>")
                }
            }
        }
    </script>
@endpush
