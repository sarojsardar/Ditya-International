@extends('backend.layout')

@section('title')
About Us | {{ config('app.name') }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-bank-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">About</h5>
                    <span>Ditya International Private Limited</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">About</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('website.storeAboutUs') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>About {{ config('app.name') }} Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Title: </label>
                                    <input type="text" name="about_us_title" class="form-control"
                                        value="{{ @$webContent->about_us_title }}">
                                    @if($errors->has('about_us_title'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('about_us_title') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Description: </label>
                                    <textarea id="description" name="about_us_content" class="form-control">
                                            {!! old('about_us_content', @$webContent->about_us_content) !!}
                                        </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        Upload Images
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Top Banner: </label>
                                    <input type="file" onchange="setDisplay1Image(event);" name="about_us_banner"
                                        class="form-control-file" accept="image/png, image/gif, image/jpeg">
                                    @if($errors->has('about_us_banner'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('about_us_banner') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Preview: </label>
                                    <div id="banner1_preview">
                                        <img src='{{ @$webContent->about_us_banner ? url('
                                            /storage/uploads/web-images/'.@$webContent->about_us_banner) :
                                        asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Side Banner: </label>
                                    <input type="file" onchange="setDisplay2Image(event);" name="about_us_side_banner"
                                        class="form-control-file" accept="image/png, image/gif, image/jpeg">
                                    @if($errors->has('about_us_side_banner'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('about_us_side_banner') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Preview: </label>
                                    <div id="banner2_preview">
                                        <img src='{{ @$webContent->about_us_side_banner ? url('
                                            /storage/uploads/web-images/'.@$webContent->about_us_side_banner) :
                                        asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
                                    </div>
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
                    Update
                </button>
            </div>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
        };

        CKEDITOR.replace('description', options);


        function setDisplay1Image(event){
            var file = event.target.files;
            $('#banner1_preview').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#banner1_preview').append("<img src='"+url+"' alt='problem image' style='height: 120px;width: auto;'>")
            }
        }
        function setDisplay2Image(event){
            var file = event.target.files;
            $('#banner2_preview').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#banner2_preview').append("<img src='"+url+"' alt='problem image' style='height: 120px;width: auto;'>")
            }
        }
</script>
@endpush