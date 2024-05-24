<div class="col-lg-12 mt-5">
    <h6>Company Details</h6>
    <hr>
</div>
<div class="col-lg-4">
    <div class="form-group">
        <label for="">Company Name</label>
        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', @$company->name) }}" readonly>
        @if($errors->has('company_name'))
            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('company_name') }}</li></ul>
        @endif    
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group">
        <label for="">Country</label>
        <select name="country" class="form-control select2-options" readonly>
            <option value="">== Choose Country ==</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" @if($country->id == $company->country) selected @endif>{{ $country->code }} | {{ $country->name }}</option>
            @endforeach
        </select>
        @if($errors->has('country'))
            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('country') }}</li></ul>
        @endif    
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group">
        <label for="">Company Address</label>
        <input type="text" name="company_address" class="form-control" value="{{ old('company_name', @$company->address) }}" readonly>
        @if($errors->has('company_address'))
            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('company_address') }}</li></ul>
        @endif    
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group">
        <label for="">Company Email</label>
        <input type="text" name="company_email" class="form-control" value="{{ old('company_name', @$company->user->email) }}" readonly>
        @if($errors->has('company_email'))
            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('company_email') }}</li></ul>
        @endif    
    </div>
</div>
{{-- <div class="col-lg-4">
    <div class="form-group">
        <label for="">Company Logo</label>
        <div class="input-group">
            <span class="input-group-btn">
              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white">
                <i class="fa fa-picture-o"></i> Choose
              </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="company_logo" value="{{ old('company_name', @$company->logo) }}" readonly>
        </div>
        @if($errors->has('company_logo'))
            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('company_logo') }}</li></ul>
        @endif    
        <div id="holder" style="margin-top:15px;max-height:100px;">
            @if (@$company->logo)
            <img src='{{ @$company->logo }}' alt='profile image' style='height: 5rem;width: auto;'>
            @endif  
        </div>                            
    </div>
</div> --}}
<div class="col-lg-4">
    <div class="form-group">
        <label for="">Company Logo</label>
        {{-- <input class="form-control-file" onchange="setDisplayImage(event);" type="file" name="company_logo" value="{{ old('company_logo', @$demand->company->logo) }}" readonly> --}}
        @if($errors->has('company_logo'))
            <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('company_logo') }}</li></ul>
        @endif    

        <div id="holder" style="max-height:100px;">
            @if(@$company->id)
            <img src='{{ url('/storage/uploads/company-logo/'.@$company->logo) }}' alt='company logo' style='height: 80px;'>
            @endif
        </div>          
</div>