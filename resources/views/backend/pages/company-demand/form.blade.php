@extends('backend.layout')

@section('title')
Company Demand Entry | {{ config('app.name') }}
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-plane-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add new Demand</h5>
                    <span>Company Demand Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Demand</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <form
        action=" @if(@$demand->id) {{ route('company-demand.update', @$demand->id) }} @else {{ route('company-demand.store') }} @endif"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if(@$demand->id)
                            <input type="hidden" name="company_id" value="{{@$demand->company->id}}">
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-lg-12">
                                <h5>Create New Demand</h5>
                                <hr>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Total Quota Required <span
                                            style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="text" id="numberInput" oninput="removeDecimals(this)"
                                        class="form-control" name="quota" value="{{ old('quota', @$demand->quota) }}"
                                        required>
                                    @if($errors->has('quota'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('quota') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Gender<span style="color: rgb(241, 69, 69)">*</span></label>

                                    <select name="gender" class="form-control select2-options" id="company-options">
                                        <option value="">== Choose Gender ==</option>
                                        @foreach($genders as $gender)
                                        <option value="{{$gender->name}}" @if($gender->name == $demand->gender) selected
                                            @endif>{{$gender->name}}</option>
                                        @endforeach
                                        <option value="both"> Both</option>

                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Age From : <span style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="number" type="text" id="numberInput" oninput="removeDecimals(this)"
                                        class="form-control" name="age_from"
                                        value="{{ old('age_from', @$demand->age_from) }}" required>
                                    @if($errors->has('age_from'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('age_from') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Age To : <span style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="text" id="numberInput" oninput="removeDecimals(this)"
                                        class="form-control" name="age_to" value="{{ old('age_to', @$demand->age_to) }}"
                                        required>
                                    @if($errors->has('age_to'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('age_to') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Height Above <span style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="number" class="form-control" name="height"
                                        value="{{ old('quota_value', @$demand->height) }}" min="0" value="0" step="any"
                                        required>
                                    @if($errors->has('height'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('height') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Weight Above<span style="color: rgb(241, 69, 69)">*</span></label>
                                    <input type="text" id="numberInput" oninput="removeDecimals(this)"
                                        class="form-control" name="weight" value="{{ old('weight', @$demand->weight) }}"
                                        required>
                                    @if($errors->has('weight'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required">{{ $errors->first('weight') }}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Experience in years<span
                                            style="color: rgb(241, 69, 69)">*</span></label>

                                    <select name="experience_year" class="form-control"
                                        id="years-options">
                                        <option value="">== Choose Experience ==</option>
                                        @foreach($years as $year)
                                        <option value="{{$year->name}}" 
                                            @if($year->name == $demand->experience_year) selected @endif>
                                            {{$year->name}} Years
                                        </option>
                                        @endforeach
                                    </select>



                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="">Education Above<span style="color: rgb(241, 69, 69)">*</span></label>

                                    <select name="education" class="form-control select2-options"
                                        id="education-options">
                                        <option value="">== Choose Education ==</option>
                                        @foreach($educations as $education)
                                        <option value="{{$education->name}}" @if($education->name == $demand->education)
                                            selected @endif>{{$education->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mb-4">
                            <h6>Other Details</h6>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <label for="" class="mb-2">Select Required Language<span style="color: rgb(241, 69, 69)">*</span></label>
                            <div class="form-group">
                                @foreach($languages as $language)
                                <div class="form-check">
                                    <input type="checkbox" name="languages[]" value="{{$language->id}}"
                                    {{ in_array($language->id, $demand->languages->pluck('id')->toArray())? 'checked' : '' }}
                                    class="form-check-input" style="cursor: pointer">
                                    <label class="form-check-label" for="{{$language->name}}"> {{$language->name}}</label><br>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-12 mt-8">
                            <div class="form-group">
                                <label for="">Demand Letter @if(!$demand->id) <span
                                        style="color: rgb(241, 69, 69)">*</span> @endif</label>
                                <input class="form-control-file" onchange="setDisplayDemandImage(event);" type="file"
                                    name="demand_letter[]" accept="image/*, .pdf"
                                    value="{{ old('demand_letter', @$demand->demand_letter) }}" multiple @if(!$demand)
                                    required @endif>
                                @if($errors->has('demand_letter'))
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $errors->first('demand_letter') }}</li>
                                </ul>
                                @endif
                                <div id="holder2" style="margin-top:15px;max-height:100px;">
                                    @if(@$demand->demand_letter)
                                    @php
                                    $letters = explode(',', @$demand->demand_letter)
                                    @endphp
                                    @foreach ($letters as $letter)
                                    @if (pathinfo(public_path('storage/uploads/company-demand-letters/' . $letter),
                                    PATHINFO_EXTENSION) == 'pdf')
                                    <img src='{{ asset('pdf-logo.jpg') }}' alt='Medical report image'
                                        style='height: 5rem;width: auto;'>
                                    @else
                                    <img src='{{ url('/storage/uploads/company-demand-letters/'.$letter)}}'
                                        alt='company logo' style='height: 80px;;margin-bottom:10px;'>
                                    @endif
                                    {{-- <img src='{{ url(' /storage/public/uploads/company-demand-letters/'.$letter)
                                        }}' alt='company logo' style='height: 80px;'> --}}
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="d-grid w-25 mt-10">
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
    function setDisplayImage(event){
            var file = event.target.files;
            $('#holder').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#holder').append("<img src='"+url+"' alt='profile image' style='height: 80px;width: auto;'>")
            }
        }

        function setDisplayDemandImage(event){
            var file = event.target.files;
            $('#holder2').empty();
            for(i=0;i<file.length;i++){
            if(file[i].name.split('.').pop() == 'pdf'){
                    let url = '{{ URL::asset('pdf-logo.jpg') }}'
                    $('#holder2').append("<img src='"+url+"' alt='passport image' style='height: 80px;width: auto;'>")

                }else{
                    let url = URL.createObjectURL(file[i]);
                    $('#holder2').append("<img src='"+url+"' alt='passport image' style='height: 80px;width: auto;'>")
                }
            }
        }
</script>

<script>
    $(document).ready(function() {

            $('.select2-options').select2();

            let companyId = @json(@$demand->company->id);
            if(companyId){
                let url = '{{ route('company-demand.getCompanyDetail', ':id') }}'
                url = url.replace(':id', companyId)

                $.ajax({
                    url: url,
                    type: 'GET',
                    error: function(err){
                        console.log(err);
                    },
                    complete: function(){
                        $('#company-info-hidden').attr('hidden', 'hidden')
                    },
                    success: function(data){
                        $('#company-info').html(data)
                    }
                })
            }else{
                $('#company-info').empty()
                // $('#company-info-hidden').find('input:text').val('');
                // $('#company-info-hidden').removeAttr('hidden', 'hidden')
            }
        });

        $(document).on("select2:open", () => {
            document.querySelector(".select2-container--open .select2-search__field").focus()
        });

        $(document).on('change', '#company-options', function(e){
            let com = e.target.value;
            let url = '{{ route('company-demand.getCompanyDetail', ':id') }}'
            url = url.replace(':id', com)

            $.ajax({
                url: url,
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                complete: function(){
                    $('#company-info-hidden').attr('hidden', 'hidden')
                },
                success: function(data){
                    $('#company-info').html(data)
                }
            })
        });

        $(document).ready(function(){
            let com = $('#company-options').val();
            if(com){
                let url = '{{ route('company-demand.getCompanyDetail', ':id') }}'
                url = url.replace(':id', com)

                $.ajax({
                    url: url,
                    type: 'GET',
                    error: function(err){
                        console.log(err);
                    },
                    complete: function(){
                        $('#company-info-hidden').attr('hidden', 'hidden')
                    },
                    success: function(data){
                        $('#company-info').html(data)
                    }
                })
            }
        })


</script>
<script>
    function removeDecimals(input) {
            // Remove any decimal points from the input value
            input.value = input.value.replace(/\./g, '');
        }
</script>

<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
        $('#lfm2').filemanager('image');
</script>

@endpush