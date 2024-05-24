@extends('backend.layout')

@section('title')
Portfolios | {{ config('app.name') }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-trophy-fill ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new Portfolio</h5>
                    <span>Portfolio Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Portfolio</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('website.portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>Portfolio Add</h5>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <label for="">Portfolio [Can be multiple]: </label>
                                        <input type="file" onchange="setDisplayImage(event);" name="portfolio[]" multiple class="form-control-file" accept="image/png, image/gif, image/jpeg">
                                        @if($errors->has('portfolio'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('portfolio') }}</li></ul>
                                        @endif
                                        @if($errors->has('portfolio.0'))
                                            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('portfolio.0') }}</li></ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <label for="">Preview: </label>
                                        <div id="image_preview">
                                            <img src='{{ asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-10">
                                    <button class="btn btn-sm btn-primary waves-effect waves-light" type="submit">Submit</button>
                                </div>
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
