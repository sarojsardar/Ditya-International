@extends('backend.layout')

@section('title')
@if($staff->id) Edit @else Create @endif Staff | {{ config('app.name') }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center me-5 gap-4">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                            <i class="tf-icons ri-group-line ri-24px"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-0">Add new Staff</h5>
                        <span>Staff Information</span>
                    </div>
                </div>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 fst-italic">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Staff</a>
                    </li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </nav>
        </div>

        <form action="@if(@$staff->id) {{ route('staff.update', @$staff->id) }} @else {{ route('staff.store') }} @endif" method="POST" enctype="multipart/form-data">
        <div class="row">
                @csrf

                @if(@$staff->id)
                    @method('PUT')
                @endif
            <div class="col-12 col-lg-8">
                <div class="card mb-6">
                    <h5 class="card-header"> @if($staff->id) Edit @else Create @endif Staff </h5>
                    <div class="card-body">
                        
        
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="">First Name <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', @$staff->userInfo->first_name) }}">
                                        @if($errors->has('first_name'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('first_name') }}</li></ul>
                                        @endif
        
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', @$staff->userInfo->middle_name) }}">
                                        @if($errors->has('middle_name'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('middle_name') }}</li></ul>
                                        @endif
        
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="">Last Name <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', @$staff->userInfo->last_name) }}">
                                        @if($errors->has('last_name'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('last_name') }}</li></ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="form-group">
                                        <label for="">Email <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <input type="text" name="email" class="form-control" value="{{ old('email', @$staff->email) }}">
                                        @if($errors->has('email'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('email') }}</li></ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="form-group">
                                        <label for="">Contact <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <input type="text" name="contact" class="form-control" value="{{ old('contact', @$staff->userInfo->contact) }}">
                                        @if($errors->has('contact'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('contact') }}</li></ul>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Marital Status <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <select name="marital_status" class="form-control">
                                            <option value="single" @if(@$staff->userInfo->marital_status == 'single') selected @endif>Single</option>
                                            <option value="married" >Married</option>
                                            <option value="divorced" @if(@$staff->userInfo->marital_status == 'divorced') selected @endif>Divorced</option>
                                        </select>
                                        @if($errors->has('marital_status'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('marital_status') }}</li></ul>
                                        @endif
                                    </div>
                                </div> --}}
                                
                                <div class="col-12 mt-4">
                                    <h6>Documents</h6>
                                    <hr>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Profile <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="profile_picture" value="{{ old('profile_picture', @$staff->userInfo->profile_picture) }}">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;">
                                            @if (@$staff->userInfo->profile_picture)
                                            <img src='{{ @$staff->userInfo->profile_picture }}' alt='profile image' style='height: 5rem;width: auto;'>
                                            @endif
                                        </div>
                                        @if($errors->has('profile_picture'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('profile_picture') }}</li></ul>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Profile </label>
                                        <input type="file" onchange="setDisplayImage(event);" name="profile_picture" class="form-control-file">
                                        @if($errors->has('profile_picture'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('profile_picture') }}</li></ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div id="image_preview">
                                        @if (@$staff->userInfo->profile_picture)
                                        <img src='{{ asset('/storage/uploads/staff-profiles/'.@$staff->userInfo->profile_picture) }}' alt='profile image' style='height: 150px;width: auto;'>
                                        @else
                                        <img src='{{ asset('avatar.png') }}' alt='profile image' style='height: 150px;width: auto;'>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card mb-6">
                    <div class="card-body">
                                <div class="col-12 mt-4">
                                    <h6>Address</h6>
                                    <hr>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Full Address <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <input type="text" name="full_address" class="form-control" value="{{ old('full_addresss', @$staff->userInfo->full_address) }}">
                                        @if($errors->has('full_address'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('full_address') }}</li></ul>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <h6>User Types</h6>
                                    <hr>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">User Type <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <select name="user_type" class="form-control" id="user_type">
                                            <option value="">== Select User Type ==</option>
                                            @foreach ($userTypes as $userTypeKey => $userTypeId)
                                                @if($userTypeKey!== 'NORMAL')  {{-- skip normal user type --}}
                                                    <option value="{{ $userTypeId }}" 
                                                        @if(isset($staff->user_types[0]->id) && $staff->user_types[0]->id == $userTypeId || $userTypeId == old('user_type')) 
                                                            selected 
                                                        @endif
                                                    >
                                                        {{ ucfirst($userTypeKey) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if($errors->has('user_type'))
                                            <ul class="parsley-errors-list filled">
                                                <li class="parsley-required text-danger">{{ $errors->first('user_type') }}</li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 mt-4">
                                    <h6>Role</h6>
                                    <hr>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Staff Role <span style="color: rgb(241, 69, 69)">*</span></label>
                                        <select name="role" class="form-control" id="role">
                                            <option value="">== Select Role ==</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @if(@$staff->roles[0]->id == $role->id || $role->id == old('role') ) selected @endif>{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('role'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required text-danger">{{ $errors->first('role') }}</li></ul>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 medical-section mt-4">
                                    <div class="form-group">
                                        <label for="">Medical</label>
                                        <select name="medical[]" id="medical" class="form-control select2 form-select" multiple>
                                            <option value="" disabled>== Select Medical Office ==</option>
                                            @foreach ($medicals as $medical)
                                                <option value="{{ $medical->id }}" 
                                                        {{ in_array($medical->id, old('medical', @$staff->medicals->pluck('id')->toArray()))? 'selected' : '' }}>
                                                    {{ ucfirst($medical->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('medical'))
                                            <ul class="parsley-errors-list filled">
                                                <li class="parsley-required text-danger">{{ $errors->first('medical') }}</li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="d-grid w-25 mt-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        Submit
                    </button>
                </div>
            </div>
            
            
        </div>
    </form>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $("#medical").select2();

        $('.medical-section').hide();

        $("#user_type").val() == 4 ? $('.medical-section').show() : $('.medical-section').hide();

        $("#user_type").change(function(){
            let selectdeType = $(this).val();
            
            if(selectdeType == 4){ // check user type medical officer
                $('.medical-section').show();
            }else{
                $('.medical-section').hide();
                $("#medical").val('').trigger('change');
            }
        })
    });

    function setDisplayImage(event){
        var file = event.target.files;
        $('#image_preview').empty();
        for(i=0;i<file.length;i++){
            let url = URL.createObjectURL(file[i]);
            $('#image_preview').append("<img src='"+url+"' alt='profile image' style='height: 200px;width: auto;'>")
        }
    }
</script>
{{-- <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script> --}}

@endpush
