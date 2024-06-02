@extends('backend.layout')

@section('title')
Medical | {{ config('app.name') }}
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-building-2-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new Medical</h5>
                    <span>Medical Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Medical</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form
        action="@if($medical->id) {{ route('medical.update', @$medical->id) }} @else {{ route('medical.store') }}  @endif"
        method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>Medical Details</h5>
                    </div>
                    <div class="card-body">
                        @csrf

                        @if($medical->id)
                        @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Medical Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', @$medical->name) }}">
                                    @if($errors->has('name'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('name') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>                            

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', @$medical->address) }}">
                                    @if($errors->has('address'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('address') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Location</label>
                                    <input type="text" name="location" class="form-control"
                                        value="{{ old('location', @$medical->location) }}">
                                    @if($errors->has('location'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('location') }}</li>
                                    </ul>
                                    @endif
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
    $(document).ready(function() {
            // Initialize select2
            $('.select2-options').select2();

            // Automatically focus the search field when select2 is opened
            $(document).on("select2:open", () => {
                document.querySelector(".select2-container--open .select2-search__field").focus();
            });

            // Display selected image(s) when files are chosen
            function setDisplayImage(event){
                var files = event.target.files;
                $('#holder').empty(); // Clear existing previews
                for(let i = 0; i < files.length; i++){
                    let url = URL.createObjectURL(files[i]);
                    $('#holder').append("<img src='" + url + "' alt='medical logo' style='height: 80px; width: auto;'>");
                }
            }

            // Make setDisplayImage globally available
            window.setDisplayImage = setDisplayImage;
        });
</script>
@endpush