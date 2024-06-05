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
                        <h5 class="mb-0">Candidate/Visa Process</h5>
                        <span>Candidate/Visa Process List Information</span>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="col-lg-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <form action="#">
        
        
                       <div class="row">
        
                            @if((int)auth()->user()->user_type == \App\Enum\UserTypes::MEDICAL_OFFICER)
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
                            @endif
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Demand:</label>
                                    <select name="demand" id="demand" class="form-control form-control-sm">
                                        <option value="">Current Demand</option>
                                        @foreach ((@$demands ?? []) as $demand)
                                            <option value="{{$demand->id}}">{{$demand->demand_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="button" id="clear_filter" class="ms-1 btn btn-sm btn-danger float-end">Clear</button>
                                <button type="button" id="filter-btn" class="btn btn-primary btn-sm float-end">Filter</button>
                            </div>
        
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-sm" id="btn-cnage-visa-process">Change Visa Status</button>
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
                                <th>S.N</th>
                                <th><input type="checkbox" id="select-all" onclick="selectAll(this)"></th>
                                <th>Visa Status</th>
                                <th>Candidate</th>
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
            <form action="{{route('company-officer.proceed-to-visa')}}" method="post" id="procees-to-visa-process" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="procees-to-visa-processLabel">Proceed to Visa</h5>
                    </div>
                    <div class="modal-body">
                        <p id="status-paragraph" class="text-danger">Are You sure Want To Change Status, You Could Not Revert This Action</p>
                        <input type="hidden" id="all_candidates" name="all_candidates" class="form-control">
                        <div class="form-group">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="Successed">Successed</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="form-group reason-div d-none">
                            <label for="">Reason <span class="text-danger">*</span></label>
                            <textarea name="reason" id="reason" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="form-group visa-div d-block">
                            <p>Note: Please Upload in PDF format</p>
                            <label for="">Visa File <span class="text-danger">*</span></label>
                            <input type="file" name="visa" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Change Status</button>
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
                url: "{{route('company-officer.candidate')}}",
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
                    'data' : 'DT_RowIndex'
                },
                { 
                    "data": "id", 
                    "orderable": false, 
                    "searchable": false, 
                    "render": function(data, type, row) {
                        console.log(row);
                        return (row.document_status == 'Completed' && (row.visa_status !== null && row.visa_status !== '' && row.visa_status !== undefined && row.visa_status !== "Successed" && row.visa_status !== "Rejected")) ? `<input type="checkbox" name="selectedCandidates[]" value="${data}">` : '';
                    }
                },
                {
                    'data':'visa_status'
                },
                {
                    'data' : 'candidate_info'
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

        flatpickr(".date_range", {
            mode:'range',
            showMonths:2,
        });

        $(document).on('change', '#status', function(e){
            e.preventDefault();
            $('.reason-div').toggleClass(['d-none', 'd-block']);
            $('.visa-div').toggleClass(['d-none', 'd-block']);
        });
        
        function selectAll(source) {
            $(source).closest('table').find('input[type="checkbox"][name="selectedCandidates[]"]').prop('checked', source.checked);
        }

        $(document).on('click', '#btn-cnage-visa-process', function(e){
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
    </script>
@endpush
