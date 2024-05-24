@extends('backend.layout')

@section('title')
Documentation Process | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-color">
                Documentation Process
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-justified" role="tablist">
                    @role(['Company'])
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-toggle="tab" href="#submission" role="tab">
                                <span class="d-none d-md-block">Submitted Documents - [<span id="submission-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-send-circle-outline h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#visa-process" role="tab">
                                <span class="d-none d-md-block">Visa Process - [<span id="visa-process-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-postage-stamp h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#visa" role="tab">
                                <span class="d-none d-md-block">Visa Received - [<span id="visa-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-postage-stamp h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#ticket" role="tab">
                                <span class="d-none d-md-block">Ticket Done - [<span id="ticket-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-ticket-confirmation h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#rejected" role="tab">
                                <span class="d-none d-md-block">Cancelled - [<span id="rejected-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-ticket-confirmation h5"></i></span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-toggle="tab" href="#new" role="tab">
                                <span class="d-none d-md-block">Documentation - [<span id="documentation-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#submission" role="tab">
                                <span class="d-none d-md-block">Submission - [<span id="submission-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-send-circle-outline h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#visa-process" role="tab">
                                <span class="d-none d-md-block">Visa Process - [<span id="visa-process-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-postage-stamp h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#visa" role="tab">
                                <span class="d-none d-md-block">Visa Received - [<span id="visa-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-postage-stamp h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#final" role="tab">
                                <span class="d-none d-md-block">Final Approval - [<span id="final-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-check-network h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#ticket" role="tab">
                                <span class="d-none d-md-block">Ticket Done - [<span id="ticket-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-ticket-confirmation h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#rejected" role="tab">
                                <span class="d-none d-md-block">Rejected - [<span id="rejected-count">0</span>]</span><span class="d-block d-md-none"><i class="mdi mdi-ticket-confirmation h5"></i></span>
                            </a>
                        </li>
                    @endrole
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @include('backend.document-process.document-view-modal')
                    @role(['Company'])
                        @include('backend.document-process.company-process')
                    @else
                        @include('backend.document-process.other-user-process')
                    @endrole

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        countDocumentRecord();
        function refreshDatatables(){
            $('#documents-datatable').DataTable().ajax.reload(null, false);
            $('#documents-submission-datatable').DataTable().ajax.reload(null, false);
            $('#visa-process-datatable').DataTable().ajax.reload(null, false);
            $('#visa-received-datatable').DataTable().ajax.reload(null, false);
            $('#final-approval-datatable').DataTable().ajax.reload(null, false);
            $('#ticket-document-datatable').DataTable().ajax.reload(null, false);
            $('#rejected-document-datatable').DataTable().ajax.reload(null, false);
        }

        function viewAdditionalDocument(id){
            let url = '{{ route('document-process.viewAdditionalDocuments', ':id') }}'
            url = url.replace(':id', id)

            let btn = event.target;

            $.ajax({
                url: url,
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                beforeSend: function(){
                    btn.innerHTML = 'Processing..'
                },
                complete: function(){
                    btn.innerHTML = "<i class='fab fa-wpforms'></i> View Documents"
                },
                success: function(res){
                    $('#document-view').html(res)
                    $('#documentViewModal').modal('toggle');
                }
            })
        }

        function moveToVisaProcess(id){
            let url = '{{ route('document-process.moveToVisaProcess', ':id') }}'
            url = url.replace(':id', id)

            let btn = event.target;

            alertify.confirm("Are you sure to continue", function (ev) {
                ev.preventDefault();
                btn.innerHTML = 'Processing..';

                $.ajax({
                    url: url,
                    type: 'GET',
                    error: function(err){
                        console.log(err);
                    },
                    complete: function(){
                        btn.innerHTML = "<i class='fab fa-creative-commons-share'></i> Move to Visa Process";
                    },
                    success: function(res){
                        if(res.status == 'success'){
                            alertify.success(res.message)
                            refreshDatatables()
                            countDocumentRecord()
                        }else {
                            alertify.error(res.message)
                        }
                        }
                    })

            }, function(ev) {
                ev.preventDefault();
                return '';
            });
        }

        function rejectCandidate(id, stage){
            let url = '{{ route('document-process.rejectCandidate', [':id',':stage']) }}'
            url = url.replace(':id', id)
            url = url.replace(':stage', stage)

            let btn = event.target;

            alertify.confirm("Are you sure to continue", function (ev) {
                ev.preventDefault();
                btn.innerHTML = 'Processing..';

                $.ajax({
                    url: url,
                    type: 'GET',
                    error: function(err){
                        console.log(err);
                    },
                    complete: function(){
                        btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Reject Candidate';
                    },
                    success: function(res){
                        if(res.status == 'success'){
                            alertify.success(res.message)
                            refreshDatatables()
                            countDocumentRecord()
                        }else {
                            alertify.error(res.message)
                        }
                        }
                    })
            }, function(ev) {
                ev.preventDefault();
                return '';
            });
        }

        function countDocumentRecord(){

            let demandId = @json($demand->id);
            let url = '{{route('document-process.countDocuments', ':id')}}'
            url = url.replace(':id', demandId)

            $.ajax({
                url: url,
                type: 'GET',
                error : function(xhr, textStatus, errorThrown ) {
                    if (textStatus === 'error') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }
                        return;
                    }
                    if (xhr.status === 500) {
                        //handle error
                    } else {
                        //handle error
                    }
                },
                success: function(res){
                    $('#documentation-count').html(res.new);
                    $('#submission-count').html(res.submission);
                    $('#visa-process-count').html(res.visaProcess);
                    $('#visa-count').html(res.visaReceived);
                    $('#final-count').html(res.final);
                    $('#ticket-count').html(res.ticket);
                    $('#rejected-count').html(res.rejected);
                }
            })
        }
    </script>
@endpush
