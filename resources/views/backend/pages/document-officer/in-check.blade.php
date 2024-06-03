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
                    <div>
                        <h5 class="mb-0">Candidate/Medical Process</h5>
                        <span>Candidate/Medical Process List Information</span>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-lg-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <form action="#">
                       <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Medical:</label>
                                    <select name="medical" id="medical" class="form-control form-control-sm">
                                        <option value="">Please Select</option>
                                        @foreach ($medicals as $medical)
                                            <option value="{{$medical->id}}">{{$medical->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Company:</label>
                                    <select name="company" id="company" class="form-control form-control-sm">
                                        <option value="">Please Select</option>
                                        @foreach ($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Checkup Date:</label>
                                    <input type="text" name="checkup_date" id="checkup_date" value="" class="date_range form-control form-control">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Status:</label>
                                    <select name="status" id="status" class="form-control form-control-sm">
                                        <option value="Fit" selected>Fit</option>
                                        <option value="Tested">Scheduled</option>
                                        <option value="Tested">Tested</option>
                                        <option value="Unfit">Unfit</option>
                                        <option value="All">All</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <button type="button" id="clear_filter" class="ms-1 btn btn-sm btn-danger float-end">Clear</button>
                                <button type="button" id="filter-btn" class="btn btn-primary btn-sm float-end">Filter</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="company-list-datatable">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all" onclick="selectAll(this)"></th>
                                <th>Checkup Date</th>
                                <th>Status</th>
                                <th>Document Status</th>
                                <th>Candidate</th>
                                <th>Company</th>
                                <th>Company Logo</th>
                                <th>Candidate Profile</th>
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



    <div class="modal fade" id="update-medical-status" tabindex="-1" role="dialog" aria-labelledby="update-medical-statusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="#" method="post" id="status-form">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="update-medical-statusLabel">Update Medical Fitness</h5>
                    </div>
                    <div class="modal-body">
                        <p id="status-paragraph"></p>
                        <input type="hidden" id="status-input" name="status">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Change Status</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{asset('flatpickr/dist/flatpickr.min.js')}}"></script>
    <script>

        let table = $('#company-list-datatable').DataTable({
            "bAutoWidth":false,
            "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
            "pageLength": 50,
            "processing": true,
            "severside": true,
            ajax: {
                url: "{{route('document-officer.candidate')}}",
                data: function(d) {
                    d.medical = $('#medical').val();
                    d.company = $('#company').val();
                    d.checkup_date = $('#checkup_date').val();
                    d.status = $('#status').val();
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
                        return (row.document_status == 'Completed') ? `<input type="checkbox" name="selectedCandidates[]" value="${data}">` : '';
                    }
                },
                {
                    'data' : 'DT_RowIndex'
                },
                {
                    'data':'checkup_date'
                },
                {
                    'data':'medical_status'
                },
                {
                    'data':'document_status'
                },
                {
                    'data' : 'candidate_info'
                },
                {
                    'data':'company_info'
                },
                {
                    'data' : 'logo'
                },
                {
                    'data' : 'profile'
                },  
                {
                    'data' : 'action'
                },
            ]
        });


        $(document).on('click', '#filter-btn', function(e){
            e.preventDefault();
            table.draw();
            let medical = $('#medical').val();
            let company = $('#company').val();
            let checkup_date = $('#checkup_date').val();
            let status = $('#status').val();
            if(medical !== null || medical !== undefined || medical !== '' || company !== null || company !== undefined || company !== '' || checkup_date !== null || checkup_date !== undefined || checkup_date !== '' || status !== null || status !== undefined || status !== ''){
                console.log(table);
                $('#company-list-datatable').DataTable().ajax.reload();
            }
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
            showMonths:2,
        });
    </script>
@endpush
