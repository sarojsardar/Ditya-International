@extends('backend.layout')

@section('title')
Candidate Document Process | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-color">
                Company Demand List
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="company-demand-datatable">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Demand Code</th>
                                <th>Company</th>
                                <th>Country</th>
                                <th>Candidates</th>
                                <th>Approved Candidates</th>
                                <th>Rejected Candidates</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
         $(document).ready(function(){
            $('#company-demand-datatable').DataTable({
                "bAutoWidth":false,
                "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
                "pageLength": 50,
                "processing": true,
                "severside": true,
                ajax: {
                    url: '{{ route('document-process.index') }}',
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
                    },
                },
                columns: [
                    {'data' : 'DT_RowIndex'},
                    {'data' : 'demand_code'},
                    {'data' : 'company'},
                    {'data' : 'country'},
                    {'data' : 'candidate_quantity'},
                    {'data' : 'approved_candidates'},
                    {'data' : 'rejected_candidates'},
                    {'data' : 'action'},
                ],
                "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false,
                }]
            })
        })
    </script>
@endpush
