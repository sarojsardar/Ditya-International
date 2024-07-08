@extends('backend.layout')
@section('title')
    Candidate List | {{ config('app.name') }}
@endsection
@push('styles');
    <link rel="stylesheet" href="{{asset('flatpickr/dist/flatpickr.min.css')}}">
@endpush
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center me-5 gap-4">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                            <i class="ri-heart-pulse-line ri-24px"></i>
                        </div>
                    </div>

                    @php
                        $bredcrumb = null;
                        $bredcrumbInfo = null;
                        switch (@$type) {
                            case \App\Enum\CandiateAccessEnum::NEW_FOR_VISA:
                                $bredcrumb = "New Candidate";
                                $bredcrumbInfo = "Candidate List After Medical Process";
                            break;
                            case \App\Enum\CandiateAccessEnum::VISA_CALLING:
                                $bredcrumb = "Visa Calling";
                                $bredcrumbInfo = "Visa Calling List";
                            break;
                            case \App\Enum\CandiateAccessEnum::VISA_RECEIVED:
                                $bredcrumb = "Visa Received";
                                $bredcrumbInfo = "Visa Received List";
                            break;
                            case \App\Enum\CandiateAccessEnum::EVISA_CALLING:
                                $bredcrumb = "E Visa Calling";
                                $bredcrumbInfo = "E Visa Calling List";
                            break;
                            case \App\Enum\CandiateAccessEnum::EVISA_RECEIVED:
                                $bredcrumb = "E Visa Rceived";
                                $bredcrumbInfo = "E Visa Received List";
                            break;
                            case \App\Enum\CandiateAccessEnum::FINAL_APPROVAL:
                                $bredcrumb = "Final Approval";
                                $bredcrumbInfo = "Final Approval List";
                            break;
                            case \App\Enum\CandiateAccessEnum::TICKETING:
                                $bredcrumb = "Ticketing";
                                $bredcrumbInfo = "Ticketing List";
                            break;
                            case \App\Enum\CandiateAccessEnum::ENGAGED:
                                $bredcrumb = "Engaged";
                                $bredcrumbInfo = "Engaged List";
                            break;

                            case \App\Enum\CandiateAccessEnum::CANCELLED:
                                $bredcrumb = "Cancelled";
                                $bredcrumbInfo = "Cancelled List";
                            break;
                            default:
                                
                            break;
                        }
                    @endphp
                    <div>
                        <h5 class="mb-0">Candidate/{{ $bredcrumb }}</h5>
                        <span>Candidate/{{ $bredcrumbInfo }}</span>
                    </div>
                </div>
                
            </div>
        </div>

        @include('backend.partial.filter-form')


        @if(@$type == \App\Enum\CandiateAccessEnum::NEW_FOR_VISA)
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm" id="proceed-btn-to-visa-process">Proceed to Visa Process</button>
                </div>
            </div>
        </div>
        @endif

        @if(@$type == \App\Enum\CandiateAccessEnum::VISA_RECEIVED)
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm" id="proceed-to-evisa-btn">Proceed To eVisa</button>
                </div>
            </div>
        </div>
        @endif


        @if(@$type == \App\Enum\CandiateAccessEnum::EVISA_RECEIVED)
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm" id="upload-document">Upload Document</button>
                </div>
            </div>
        </div>
        @endif


        @if(@$type == \App\Enum\CandiateAccessEnum::TICKETING)
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm" id="final-status">Update Engaged Status</button>
                </div>
            </div>
        </div>
        @endif

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="company-list-datatable">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all" onclick="selectAll(this)"></th>
                                <th>Candidate</th>
                                <th>Candidate Profile</th>
                                <th>Company</th>
                                <th>Company Logo</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(@$type == \App\Enum\CandiateAccessEnum::NEW_FOR_VISA)
    <div class="modal fade" id="procees-to-visa-process" tabindex="-1" role="dialog" aria-labelledby="procees-to-visa-processLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('document-officer.proceed-to-visa')}}" method="post" id="procees-to-visa-process">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="procees-to-visa-processLabel">Proceed to Visa</h5>
                    </div>
                    <div class="modal-body">
                        <p id="status-paragraph" class="text-danger">are You sure Want To Proceed, You Could Not Revert This Action</p>
                        <input type="hidden" id="all_candidates3" name="all_candidates" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Proceed To Visa Process</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>
    @endif


    @if(@$type == \App\Enum\CandiateAccessEnum::VISA_RECEIVED)
    <div class="modal fade" id="proceed-to-evisa-process" tabindex="-1" role="dialog" aria-labelledby="proceed-to-evisa-processLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('document-officer.proceed-to-evisa')}}" method="post" id="proceed-to-evisa">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="proceed-to-evisa-processLabel">Proceed To evisa</h5>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="all_candidates" name="all_candidates" class="form-control">
                       <span class="text-danger">Are You Sure, This action could not be revert</span>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>
    @endif

    @if(@$type == \App\Enum\CandiateAccessEnum::EVISA_RECEIVED)
    <div class="modal fade" id="document-upload-modal" tabindex="-1" role="dialog" aria-labelledby="document-upload-modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('document-officer.upload-candidate-document')}}" method="post" id="uplod-document-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="document-upload-modalLabel">Upload Document</h5>
                    </div>
                    <div class="modal-body">
                        <p id="status-paragraph" class="text-danger">Please Upload The Correct document</p>
                        <input type="hidden" id="all_candidates1" name="all_candidates" class="form-control">
                        <div class="form-group">
                            <label for="">Labour Permit</label>
                            <input type="file" class="form-control" name="labour_permit">
                        </div>

                        <div class="form-group">
                            <label for="">E Ticket</label>
                            <input type="file" class="form-control" name="eticket">
                        </div>

                        <div class="form-group">
                            <label for="">Flight Departure Date</label>
                            <input type="text" class="form-control min_today_date" name="departure_date">
                        </div>
                        <div class="form-group">
                            <label for="">Candidate Arrival Date <span style="color:red">Befor Departure Date</span></label>
                            <input type="text" class="form-control min_today_date" name="arrival_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>
    @endif

    @if(@$type == \App\Enum\CandiateAccessEnum::TICKETING)
    <div class="modal fade" id="final-status-modal" tabindex="-1" role="dialog" aria-labelledby="final-status-modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('document-officer.candidate-final-status')}}" method="post" id="final-status-form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="final-status-modalLabel">Update Status</h5>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="all_candidates2" name="all_candidates" class="form-control">
                       <span class="text-danger">Are You Sure, This action could not be revert</span>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>
    @endif


    


    
@endsection

@push('scripts')
    <script src="{{asset('flatpickr/dist/flatpickr.min.js')}}"></script>
    <script src="{{asset('axios/dist/axios.js')}}"></script>
    <script>

        let table = $('#company-list-datatable').DataTable({
            "bAutoWidth":false,
            "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
            "pageLength": 50,
            "processing": true,
            "severside": true,
            ajax: {
                url: "{{route('document-officer.candidate-data')}}",
                data: function(d) {
                    d.type = "{{ @$type }}";
                    d.company = $('#company').val();
                    d.demand = $('#demand').val();
                    d.medical = $('#medical').val();
                    d.checkup_date = $('#checkup_date').val();
                    d.selected_date = $('#selected_date').val();
                    d.medical_status = $('#medical_status').val();
                    d.document_status = $('#document_status').val();
                    d.visa_status = $('#visa_status').val();
                    d.interview_status = $('#interview_status').val();
                    d.evisa_status = $('#evisa_status').val();
                    d.labour_permit_status = $('#labour_permit_status').val();
                    d.eticket_status = $('#eticket_status').val();
                    d.engaged_status = $('#engaged_status').val();
                },
                type: 'GET',
                tryCount : 0,
                retryLimit : 3,
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
                }
            },
            columns: [
                { 
                    "data": "id", 
                    "orderable": false, 
                    "searchable": false, 
                    "render": function(data, type, row) {
                        let returnStrng = '';
                        console.log(row);
                        let testCheck = (
                            (row.document_status == 'Completed' && (row.visa_status == 'Successed'))
                                &&
                            (
                                (
                                    row.evisa_status == '' ||
                                    row.evisa_status == null ||
                                    row.evisa_status == undefined
                                )
                                ||
                                ( 
                                    row.labour_permit_status == '' ||
                                    row.labour_permit_status == null ||
                                    row.labour_permit_status == undefined
                                )
                                ||
                                (  
                                    row.eticket_status == '' ||
                                    row.eticket_status == null ||
                                    row.eticket_status == undefined 
                                )
                            )
                        );

                        @if(@$type=="new_for_visa")
                        testCheck = (
                            (row.document_status == 'Completed')
                                &&
                            (
                                (
                                    row.evisa_status == '' ||
                                    row.evisa_status == null ||
                                    row.evisa_status == undefined
                                )
                                ||
                                ( 
                                    row.labour_permit_status == '' ||
                                    row.labour_permit_status == null ||
                                    row.labour_permit_status == undefined
                                )
                                ||
                                (  
                                    row.eticket_status == '' ||
                                    row.eticket_status == null ||
                                    row.eticket_status == undefined 
                                )
                            )
                        );
                        @endif

                        let againTest = true;
                        @if(@$type=="ticketing")
                            testCheck = (
                                (row.document_status == 'Completed' && (row.visa_status == 'Successed'))
                                    &&
                                (
                                    (
                                        row.evisa_status == 'Successed' 
                                    )
                                    ||
                                    ( 
                                        row.labour_permit_status == 'Successed'
                                    )
                                    ||
                                    (  
                                        row.eticket_status == 'Successed'
                                    )
                                )
                            );
                            againTest = (row.user_demand_status !== "Completed" && row.demand_status !== "Completed");
                            // testCheck = true;
                            // againTest = true;
                        @endif


                        console.log(againTest);
                        if((testCheck && againTest)){
                            returnStrng = `<input type="checkbox" name="selectedCandidates[]" value="${data}">`;
                        }
                        return returnStrng;
                    }
                },
                {
                    'data' : 'candidate_info'
                },
                {
                    'data' : 'profile'
                },
                {
                    'data':'company_info'
                },
                {
                    'data' : 'logo'
                },
                {
                    'data' : 'action'
                },
            ]
        });


        $(document).on('click', '.btn-action-status', function(e){
            e.preventDefault();
            let status = $(this).data('value');
            var statusAction = "{{ route('medical-officer.update-checkup-status', '#medical_id') }}";
            let medical_checkup = $(this).data('medical_checkup');
            let candidate =  $(this).data('candidate');
            let confirmation = `
                    <span class="text-red"> </span>You are going to update the status of candiate, This action can not be reversed, So please read carefully and update this</span>
                    <br/>
                    Cndidate:${candidate}
                    <br/>
                    Status: ${status}
                    `;
            statusAction = statusAction.replace('#medical_id', medical_checkup);
            $('#status-form').attr('action', statusAction);
            $('#status-paragraph').html(confirmation);
            $('#status-input').val(status);
            $('#update-medical-status').modal('show');
        });

        flatpickr(".date_range", {
            mode:'range',
            enableTime: true,
            showMonths:2,
        });



        flatpickr(".min_today_date", {
            showMonths:2,
            enableTime: true,
            minDate: 'today'
        });

        function selectAll(source) {
            $(source).closest('table').find('input[type="checkbox"][name="selectedCandidates[]"]').prop('checked', source.checked);
        }

        $(document).on('click', '#upload-document', function(e){
            e.preventDefault();
            const selectedCandidates = [];
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selectedCandidates[]"]:checked');
            checkboxes.forEach((checkbox) => {
                selectedCandidates.push(checkbox.value);
            });
            if(selectedCandidates.length <= 0){
                alert("Sorry Please Select at least one candidate to move to medical");
                return;
            }
            $('#all_candidates1').val(JSON.stringify(selectedCandidates));
            $('#document-upload-modal').modal('show');
        });


        $(document).on('click', '#proceed-to-evisa-btn', function(e){
            e.preventDefault();
            const selectedCandidates = [];
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selectedCandidates[]"]:checked');
            checkboxes.forEach((checkbox) => {
                selectedCandidates.push(checkbox.value);
            });
            if(selectedCandidates.length <= 0){
                alert("Sorry Please Select at least one candidate to move to medical");
                return;
            }
            $('#all_candidates').val(JSON.stringify(selectedCandidates));
            $('#proceed-to-evisa-process').modal('show');
        });


        $(document).on('click', '#final-status', function(e){
            e.preventDefault();
            const selectedCandidates = [];
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selectedCandidates[]"]:checked');
            checkboxes.forEach((checkbox) => {
                selectedCandidates.push(checkbox.value);
            });
            if(selectedCandidates.length <= 0){
                alert("Sorry Please Select at least one candidate to move to medical");
                return;
            }
            $('#all_candidates2').val(JSON.stringify(selectedCandidates));
            $('#final-status-modal').modal('show');
        });



        $(document).on('click', '#proceed-btn-to-visa-process', function(e){
            e.preventDefault();
            const selectedCandidates = [];
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selectedCandidates[]"]:checked');
            checkboxes.forEach((checkbox) => {
                selectedCandidates.push(checkbox.value);
            });
            if(selectedCandidates.length <= 0){
                alert("Sorry Please Select at least one candidate to move to medical");
                return;
            }
            $('#all_candidates3').val(JSON.stringify(selectedCandidates));
            $('#procees-to-visa-process').modal('show');
        });

        




       
        // for the filter button
        $(document).on('click', '#filter-btn', function(e){
            e.preventDefault();
            $('#company-list-datatable').DataTable().ajax.reload();
        });


        $(document).on('click', '#clear_filter', function(e){
            e.preventDefault();
            $('#company').val();
            $('#demand').val();
            $('#medical').val();
            $('#checkup_date').val();
            $('#selected_date').val();
            $('#medical_status').val();
            $('#document_status').val();
            $('#visa_status').val();
            $('#interview_status').val();
            $('#evisa_status').val();
            $('#labour_permit_status').val();
            $('#eticket_status').val();
            $('#engaged_status').val();

            $('#company-list-datatable').DataTable().ajax.reload();
        });


        $(document).on('change', '#company', function(e){
            e.preventDefault();
            fetchDemand();
        })

        function fetchDemand(){
            let company = $('#company').val();
            axios.get('/all-officer/candidate/get-demand', {
                params:{
                    'company':company,
                }
            }).then((response)=>{
                let demands = response.data.data;
                let htmlString = '<option value="">Please Select</option>';
                demands.forEach(demand => {
                    htmlString += `<option value="${demand.id}">${demand.demand_code} (${demand.status})</option>`; 
                });
                $('#demand').html(htmlString);

            }).catch((error)=>{
                console.log(error);
            }).finally(()=>{
                
            })
        }

        

        
    </script>
@endpush
