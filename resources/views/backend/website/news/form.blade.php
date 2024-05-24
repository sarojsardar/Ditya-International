@extends('backend.layout')

@section('title')
News | {{ config('app.name') }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-news-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new News</h5>
                    <span>News Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">News</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form action="{{ @$news->id ? route('website.news.update', @$news->id) : route('website.news.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (@$news->id)
        @method('PUT')
        @endif

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>News Add</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="">Title: <span style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="text" name="title" value="{{ old('title', @$news->title) }}"
                                        placeholder="" class="form-control" required>
                                    @if($errors->has('title'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('title') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="">Description: </label>
                                    <textarea id="description" name="description" class="form-control" required>
                                            {!! old('description', @$news->content) !!}
                                        </textarea>
                                    @if($errors->has('description'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('description') }}</li>
                                    </ul>
                                    @endif
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
                                    <label for="">Thumbnail: @if(@!$news->id) <span
                                            style="color: rgb(241, 69, 69)">*</span> @endif</label>
                                    <input type="file" onchange="setDisplayImage(event);" name="thumbnail"
                                        class="form-control-file" accept="image/png, image/gif, image/jpeg">
                                    @if($errors->has('thumbnail'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('thumbnail') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Preview: </label>
                                    <div id="image_preview">
                                        <img src='{{ @$news->thumbnail ? url('
                                            /storage/uploads/news-images/'.$news->thumbnail) : asset('no-file.png') }}'
                                        alt='preview' style='height: 120px;width: auto;'>
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
                    Submit
                </button>
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