@extends('backend.layout')

@section('title')
Staff List | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="tf-icons ri-group-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Staff List</h5>
                    <span>List of staff and its details</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Staff</a>
                </li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="staffs-datatable">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Profile</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Designation</th>
                                <th>Registered Date</th>
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

    $('#staffs-datatable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'excel', 'csv'
        ],
        "bAutoWidth":false,
        "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
        "pageLength": 50,
        "processing": true,
        "severside": true,
        ajax: {
            url: "{{route('staff.index')}}",
            type: 'GET',
            tryCount : 0,
            retryLimit : 3,
            error:function(err){
                console.log(err);
            },
            // error : function(xhr, textStatus, errorThrown ) {
            //     if (textStatus === 'error') {
            //         this.tryCount++;
            //         if (this.tryCount <= this.retryLimit) {
            //             //try again
            //             $.ajax(this);
            //             return;
            //         }
            //         return;
            //     }
            //     if (xhr.status === 500) {
            //         //handle error
            //     } else {
            //         //handle error
            //     }
            // }
        },
        columns: [
            {'data' : 'DT_RowIndex'},
            {'data' : 'profile'},
            {'data' : 'username'},
            {'data' : 'fullname'},
            {'data' : 'email'},
            {'data' : 'contact'},
            {'data' : 'address'},
            {'data' : 'role'},
            {'data' : 'created_at'},
            {'data' : 'action'},
        ]
    })

        // $("#staff_search_box").on("keyup", function() {
        //     let value = $(this).val().toLowerCase();

        //     $(".search-area").filter(function() {
        //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //     });
        // });

    </script>
@endpush
