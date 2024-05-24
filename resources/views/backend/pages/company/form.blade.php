@extends('backend.layout')

@section('title')
Company | {{ config('app.name') }}
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
                    <h5 class="mb-0">Add new Company</h5>
                    <span>Company Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Company</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form
        action="@if($company->id) {{ route('company.update', @$company->id) }} @else {{ route('company.store') }}  @endif"
        method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        <h5>Company Detail</h5>
                    </div>
                    <div class="card-body">
                        @csrf

                        @if($company->id)
                        @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Company Name</label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ old('company_name', @$company->name) }}">
                                    @if($errors->has('company_name'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('company_name') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Country</label>
                                    <select name="country" class="form-control select2-options">
                                        <option value="">== Choose Country ==</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" @if($country->id == $company->country)
                                            selected @endif>{{ $country->code }} | {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('country'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('country') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Select Category</label>
                                    <select name="categories[]" class="form-control select2-options" multiple>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if(is_array(old('categories')) &&
                                            in_array($category->id, old('categories')))
                                            selected
                                            @elseif(isset($company->categories) &&
                                            $company->categories->contains($category->id))
                                            selected
                                            @endif
                                            >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('category'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('category') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Company Address</label>
                                    <input type="text" name="company_address" class="form-control"
                                        value="{{ old('company_address', @$company->address) }}">
                                    @if($errors->has('company_address'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('company_address') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Company Email</label>
                                    <input type="text" name="company_email" class="form-control"
                                        value="{{ old('company_email', @$company->user->email) }}">
                                    @if($errors->has('company_email'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('company_email') }}</li>
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
                        <h6>Company Logo</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12 mb-4">
                            <div class="form-group">
                                <label for="">Select Logo</label>
                                <input class="form-control-file" onchange="setDisplayImage(event);" type="file"
                                    name="company_logo" value="{{ old('company_logo', @$demand->company->logo) }}"
                                    accept="image/png, image/gif, image/jpeg">
                                @if($errors->has('company_logo'))
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $errors->first('company_logo') }}</li>
                                </ul>
                                @endif

                                <div id="holder" style="margin-top:15px;max-height:100px;">
                                    @if(@$company->id)
                                    <img src='{{ url(' /storage/uploads/company-logo/'.@$company->logo) }}'
                                    alt='company logo' style='height: 80px;'>
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
                    $('#holder').append("<img src='" + url + "' alt='company logo' style='height: 80px; width: auto;'>");
                }
            }

            // Make setDisplayImage globally available
            window.setDisplayImage = setDisplayImage;
        });
</script>
@endpush