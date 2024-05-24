@extends('backend.layout')

@section('title')
Gallery Category | {{ config('app.name') }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-folder-image-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add New Gallery Category</h5>
                    <span>Gallery Category Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Gallery Category</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form
        action="{{ @$category->id ? route('website.gallery.category.updateCategory', @$category->id) : route('website.gallery.category.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (@$category->id)
        @method('PUT')
        @endif

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>Category Add</h5>
                    </div>
                    <div class="card-body">

                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label for="">Category Name: <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input type="text" name="category_name"
                                    value="{{ old('category_name', @$category->category_name) }}"
                                    placeholder="Eg: Annual Function, Flight Away, etc" class="form-control">
                                @if($errors->has('category_name'))
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $errors->first('category_name') }}</li>
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label for="">Thumbnail: @if(@!$category->id) <span
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
                                    <img src='{{ @$category->thumbnail ? url('
                                        /storage/uploads/category-images/'.$category->thumbnail) :
                                    asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-6">
                            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>


</div>
@endsection

@push('scripts')
<script>
    // CKEDITOR.replace('description');


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