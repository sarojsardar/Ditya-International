@extends('backend.layout')

@section('title')
Splashs | {{ config('app.name') }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-scan-2-fill ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new Splash</h5>
                    <span>Splash Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Splash</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form
        action="@if($splash->id) {{ route('website.splash.update', $splash->id) }} @else {{ route('website.splash.store') }} @endif"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>Splash @if($splash->id) Edit @else Add @endif</h5>
                    </div>
                    <div class="card-body">
                        @if($splash->id)
                        @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Title: </label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', @$splash->title) }}">
                                    @if($errors->has('title'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('title') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        Upload Image
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Splash: </label>
                                    <input type="file" onchange="setDisplayImage(event);" name="image"
                                        class="form-control-file">
                                    @if($errors->has('image'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('image') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Logo Preview: </label>
                                    <div id="image_preview">
                                        <img src='{{ @$splash->image ? url(' /storage/uploads/splashs/'.$splash->image)
                                        : asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
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
                @if ($splash->id)
                <button class="btn btn-primary waves-effect waves-light" type="submit">Update</button>
                @else
                <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
                @endif
            </div>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    CKEDITOR.replace('description');
        function setDisplayImage(event){
            var file = event.target.files;
            $('#image_preview').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#image_preview').append("<img src='"+url+"' alt='problem image' style='height: 120px;width: auto;'>")
            }
        }
</script>
@endpush