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


        @include('backend.partial.filter-form')

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
                        <input type="hidden" id="all_candidates" name="all_candidates" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Proceed To Visa Process</button>
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
                        console.log(row);
                        return (row.document_status == 'Completed' && (row.visa_status == null || row.visa_status == '' || row.visa_status == undefined)) ? `<input type="checkbox" name="selectedCandidates[]" value="${data}">` : '';
                    }
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


        function selectAll(source) {
            $(source).closest('table').find('input[type="checkbox"][name="selectedCandidates[]"]').prop('checked', source.checked);
        }

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
            $('#all_candidates').val(JSON.stringify(selectedCandidates));
            $('#procees-to-visa-process').modal('show');
        });


        $(document).on('click', '#clear_filter', function(e){
            e.preventDefault();
            $('#medical').val('');
            $('#company').val('');
            $('#checkup_date').val('');
            $('#status').val('');
            $('#company-list-datatable').DataTable().ajax.reload();
        });
    </script>
@endpush
