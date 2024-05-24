@extends('backend.layout')

@section('title')
Candidate Ticket Details | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header card-header-color">
                Upload Ticket of <span style="font-size: 16px">{{ $candidate->first_name.' '.$candidate->middle_name.' '.$candidate->last_name }}</span>
            </div>
            <div class="card-body">

                <form action="{{ route('document-process.uploadTicketDocument', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h6>Ticket Details</h6>
                            <hr>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Ticket Image <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input class="form-control-file" onchange="setDisplayImage(event);" type="file" name="ticket[]" multiple accept="image/*, .pdf" required>
                                @if($errors->has('ticket'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('ticket') }}</li></ul>
                                @endif
                                <div id="holder" style="margin-top:15px;max-height:300px;">
                                    <img src='{{ asset('no-file.png') }}' alt='visa image' style='height: 10rem;width: auto;'>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Flight Date & Time <span style="color: rgb(241, 69, 69)">*</span></label>
                                <input type="datetime-local" name="flight_date" class="form-control" value="{{ old('flight_date') }}" required>
                                @if($errors->has('flight_date'))
                                    <ul class="parsley-errors-list filled"><li class="parsley-required">{{ $errors->first('flight_date') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
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
        function setDisplayImage(event){
            var file = event.target.files;
            $('#holder').empty();
            for(i=0;i<file.length;i++){
                if(file[i].name.split('.').pop() == 'pdf'){
                    let url = '{{ URL::asset('pdf-logo.jpg') }}'
                    $('#holder').append("<img src='"+url+"' alt='profile image' style='height: 10rem;width: auto;'>")

                }else{
                    let url = URL.createObjectURL(file[i]);
                    $('#holder').append("<img src='"+url+"' alt='profile image' style='height: 10rem;width: auto;'>")
                }
            }
        }
    </script>
@endpush
