@extends('backend.layout')

@section('title')
Category | {{ config('app.name') }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-menu-unfold-fill ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new Category</h5>
                    <span>Category Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Category</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>
    
        <div class="col-lg-6">
            <div class="card mt-4">
                <div class="card-header card-header-color">
                   <h5>Category Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ @$categories->id ? route('categories.update', @$categories->id) : route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (@$categories->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Title: <span style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', @$categories->name) }}" placeholder="" class="form-control" required>
                                    @if($errors->has('name'))
                                        <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('name') }}</li></ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
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
