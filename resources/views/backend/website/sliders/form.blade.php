@extends('backend.layout')

@section('title')
Sliders | {{ config('app.name') }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-equalizer-3-fill ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new Slider</h5>
                    <span>Slider Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Slider</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form
        action="@if($slider->id) {{ route('website.slider.update', $slider->id) }} @else {{ route('website.slider.store') }} @endif"
        method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>Slider @if($slider->id) Edit @else Add @endif</h5>
                    </div>
                    <div class="card-body">
                        @if($slider->id)
                        @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Title: </label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', @$slider->title) }}">
                                    @if($errors->has('title'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('title') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Description: </label>
                                    <textarea id="description" name="description" class="form-control">
                                                {!! old('description', @$slider->description) !!}
                                            </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        Upload Image
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Slider: </label>
                                    <input type="file" onchange="setDisplayImage(event);" name="slider_image"
                                        class="form-control-file">
                                    @if($errors->has('slider_image'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('slider_image') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Logo Preview: </label>
                                    <div id="image_preview">
                                        <img src='{{ @$slider->image ? url(' /storage/uploads/sliders/'.$slider->image)
                                        :
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
                @if ($slider->id)
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