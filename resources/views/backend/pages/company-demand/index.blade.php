@extends('backend.layout')

@section('title')
Company Demands | {{ config('app.name') }}
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
                    <h5 class="mb-0">Demand List</h5>
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
                <li class="breadcrumb-item active">List</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="company-demands-datatable">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Quota</th>
                                <th>Demand Code</th>
                                <th>Gender</th>
                                <th>Age From</th>
                                <th>Age To</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>Experience</th>
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

@endsection

@push('scripts')
    <script>

        $('#company-demands-datatable').DataTable({
            "bAutoWidth":false,
            "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
            "pageLength": 50,
            "processing": true,
            "severside": true,
            ajax: {
                url: "{{route('company-demand.index')}}",
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
                {'data' : 'DT_RowIndex'},
                {'data' : 'quota'},
                {'data' : 'demand_code'},
                {'data' : 'gender'},
                {'data' : 'age_from'},
                {'data' : 'age_to'},
                {'data' : 'height'},
                {'data' : 'weight'},
                {'data' : 'experience_year'},
                {'data' : 'action'},
            ],
            createdRow: (row, data, dataIndex, cells) => {
                $(row).css('background-color', data.color);
            },
            "columnDefs": [{
            "targets": [0],
            "orderable": false,
            "searchable": false,
            }]
        })


    </script>
@endpush
