@extends('backend.layout')

@section('title')
    Companies List | {{ config('app.name') }}
@endsection

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
                        <h5 class="mb-0">Medical Process</h5>
                        <span>Medical Process List Information</span>
                    </div>
                </div>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 fst-italic">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Medical</a>
                    </li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </nav>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="company-list-datatable">
                            <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Logo</th>
                                <th>Company</th>
                                <th>Medical Status</th>
                                <th>Company Country</th>
                                <th>Company Address</th>
                                <th>Category</th>
                                <th>Email</th>
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

        $('#company-list-datatable').DataTable({
            "bAutoWidth":false,
            "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
            "pageLength": 50,
            "processing": true,
            "severside": true,
            ajax: {
                url: "{{route('receptionist.medical.company.index')}}",
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
                    'data' : 'logo'
                },
                {
                    'data' : 'name'
                },
                {
                    'data' : 'medical_status'
                },
                {
                    'data' : 'country'
                },
                {
                    'data' : 'address'
                },
                {
                    'data': 'categories'
                },
                {
                    'data' : 'email'
                },
                {
                    'data' : 'action'
                },
            ]
        })

    </script>
@endpush
