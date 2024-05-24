@extends('backend.layout')

@section('title')
Settings | {{ config('app.name') }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-settings-4-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Setting</h5>
                    <span>Setting Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Setting</a>
                </li>
                <li class="breadcrumb-item active">Update</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('website.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-6 mt-3">
                <div class="card m6">
                    <div class="card-header card-header-color">
                        <h5>General Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Site Name: </label>
                                    <input type="text" name="site_name"
                                        value="{{ old('site_name', @$currentSetting->site_name) }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Location: </label>
                                    <textarea name="location"
                                        class="form-control">{{ old('location', @$currentSetting->location) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">contact: </label>
                                    <input type="text" name="contact"
                                        value="{{ old('contact', @$currentSetting->contact) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Official Email: </label>
                                    <input type="text" name="official_email"
                                        value="{{ old('official_email', @$currentSetting->official_email) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Facebook Link: </label>
                                    <input type="text" name="fb_link"
                                        value="{{ old('fb_link', @$currentSetting->fb_link) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Instagram Link: </label>
                                    <input type="text" name="insta_link"
                                        value="{{ old('insta_link', @$currentSetting->insta_link) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Tiktok Link: </label>
                                    <input type="text" name="tiktok_link"
                                        value="{{ old('tiktok_link', @$currentSetting->tiktok_link) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Whatsapp: </label>
                                    <input type="text" name="whatsapp"
                                        value="{{ old('whatsapp', @$currentSetting->whatsapp) }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        Upload Images
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Site Logo: </label>
                                    <input type="file" onchange="setDisplayImage(event);" name="site_logo"
                                        class="form-control-file">
                                    @if($errors->has('site_logo'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('site_logo') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Logo Preview: </label>
                                    <div id="image_preview">
                                        <img src='{{ @$currentSetting->site_logo ? url('
                                            /storage/uploads/site-logo/'.$currentSetting->site_logo) :
                                        asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Site Logo Small: </label>
                                    <input type="file" onchange="setDisplayImage2(event);" name="site_logo_sm"
                                        class="form-control-file">
                                    @if($errors->has('site_logo_sm'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('site_logo_sm') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Small Logo Preview: </label>
                                    <div id="image_preview2">
                                        <img src='{{ @$currentSetting->site_logo_sm ? url('
                                            /storage/uploads/site-logo/'.$currentSetting->site_logo) :
                                        asset('no-file.png') }}' alt='preview' style='height: 120px;width: auto;'>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Map: </label>
                                    <textarea id="map" name="map" class="form-control"
                                        rows="9">{!! old('map', @$currentSetting->map) !!}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="card mb-6">
                    <div class="card-header card-header-color">
                        Other Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="">Map: </label>
                                    <textarea id="map" name="map" class="form-control"
                                        rows="15">{!! old('map', @$currentSetting->map) !!}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="">Description: </label>
                                    <textarea id="description" name="description" class="form-control">
                                                {!! old('description', @$currentSetting->description) !!}
                                            </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Terms & Conditions: </label>
                                    <textarea id="terms_and_condition" name="terms_and_condition" class="form-control">
                                                {!! old('terms_and_condition', @$currentSetting->terms_and_condition) !!}
                                            </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="">Privacy & Policy: </label>
                                    <textarea id="privacy_and_policy" name="privacy_and_policy" class="form-control">
                                                {!! old('privacy_and_policy', @$currentSetting->privacy_and_policy) !!}
                                            </textarea>
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
                    @php echo @$currentSetting->id ? 'Update' : 'Submit' @endphp
                </button>
            </div>
        </div>

    </form>



</div>
@endsection

@push('scripts')
<script>
    // CKEDITOR.replace('map');
        CKEDITOR.replace('description');
        CKEDITOR.replace('terms_and_condition');
        CKEDITOR.replace('privacy_and_policy');

        function setDisplayImage(event){
            var file = event.target.files;
            $('#image_preview').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#image_preview').append("<img src='"+url+"' alt='problem image' style='height: 120px;width: auto;'>")
            }
        }

        function setDisplayImage2(event){
            var file = event.target.files;
            $('#image_preview2').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#image_preview2').append("<img src='"+url+"' alt='problem image' style='height: 120px;width: auto;'>")
            }
        }
</script>
@endpush