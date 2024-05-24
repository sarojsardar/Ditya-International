@extends('backend.layout')

@section('title')
Profile | {{ config('app.name') }}
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="tf-icons ri-user-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Profile</h5>
                    <span>Profile Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Profile</a>
                </li>
                <li class="breadcrumb-item active">Update</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('profile.updateProfile') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <h5 class="card-header"> User Information </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" value="{{ auth('web')->user()->username }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" value="{{ auth('web')->user()->email }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <h5 class="card-header"> Upload Image </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="">Profile Picture</label>
                                    <input id="profile_upload_input" type="file" class="form-control-file"
                                        onchange="uploadProfile();">
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group text-center" id="holder">
                                    @role(['Company'])
                                    @if(@auth('web')->user()->companyInfo->logo)
                                    <img src="{{ url('/storage/public/uploads/company-logo/'. auth('web')->user()->companyInfo->logo) }}"
                                        alt="" style="height: 60px;width:auto;">
                                    @else
                                    <img src="{{ asset('no-profile.jpg') }}" alt="" style="height: 60px;width:auto;">
                                    @endif
    
                                    @else
                                    @if(@auth('web')->user()->userInfo->profile_picture)
                                    <img src="{{ url('/storage/public/uploads/staff-profiles/'.auth('web')->user()->userInfo->profile_picture) }}"
                                        alt="" style="height: 60px;width:auto;">
                                    @else
                                    <img src="{{ asset('no-profile.jpg') }}" alt="" style="height: 60px;width:auto;">
                                    @endif
                                    @endrole
                                </div>
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

    </form>
</div>

@endsection

@push('scripts')
<script>
    function uploadProfile(){
            let img = event.target.files[0];
            let formData = new FormData();
            formData.append('profile_picture', img);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route('profile.uploadProfile') }}',
                type: 'POST',
                data: formData,
                error: function(err){
                    console.log(err);
                },
                beforeSend: function(){
                    alertify.alert('Uploading...')
                },
                success: function(res){
                    if(res.status == 'success'){
                        alertify.success(res.message)
                        let url = URL.createObjectURL(img);
                        $('#holder').empty();
                        $('#holder').append("<img src='"+url+"' alt='' style='height: 80px;width: auto;'>")
                        $('#main-profile-img').html("<img src='"+url+"' alt='user' class='rounded-circle'>")
                        $('#profile_upload_input').val(null)
                    }else {
                        alertify.error(res.message)
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
</script>
@endpush