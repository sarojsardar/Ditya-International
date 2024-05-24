@extends('backend.layout')

@section('title')
    Demands | {{ config('app.name') }}
@endsection

@section('content')
    <!-- Select extension CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <!-- Trigger Button -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                        Approve And Send Notification
                    </button>
                    <!-- Modal Structure -->
                    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel">Interview Invites</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Display the interview details here -->
                                    <form id="interviewDetailsForm">
                                        <div class="form-group">
                                            <label for="interviewDate">Interview Date</label>
                                            <input type="date" class="form-control" id="interviewDate" value="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="interviewTime">Interview Time</label>
                                            <input type="time" class="form-control" id="interviewTime" value="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="interviewVenue">Interview Venue</label>
                                            <input type="text" class="form-control" id="interviewVenue" value="" >
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="confirmUpdateStatus">Approve</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-4 mb-xl-0">
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3 mb-md-0">
                                        <div class="list-group">
                                            @forelse($demands as $demand)
                                                <a class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }}"
                                                   id="list-demand-list{{ $demand->id }}"
                                                   data-bs-toggle="list"
                                                   href="#list-demand{{ $demand->id }}">
                                                    {{ $demand->demand_code }}
                                                </a>

                                            @empty
                                                <div class="alert d-flex align-items-center alert-danger mb-0 h5" role="alert">
                                                    <span class="alert-icon rounded-3">
                                                        <i class="ri-information-line ri-22px"></i>
                                                    </span>
                                                    No Demand Created
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>
                                    <div class="col-md-10 col-12">
                                        <div class="tab-content p-0">
                                            @forelse($demands as $demand)
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="list-demand{{ $demand->id }}">
                                                    <h5 class="text-light fw-medium">Candidates List of - {{ $demand->demand_code }}</h5>
                                                    <div class="demo-inline-spacing mt-3">
                                                        <div class="list-group list-group-horizontal-md text-md-center">

                                                            <a class="list-group-item list-group-item-action active"
                                                               id="approved-candidates-tab{{ $demand->id }}"
                                                               data-bs-toggle="list"
                                                               href="#approved-candidates-content{{ $demand->id }}">Approved Candidates</a>

                                                            <a class="list-group-item list-group-item-action "
                                                               id="interview-candidates-tab{{ $demand->id }}"
                                                               data-bs-toggle="list"
                                                               href="#interview-candidates-content{{ $demand->id }}">Interview Candidates</a>

                                                        </div>
                                                        <div class="tab-content px-0 mt-0">

                                                            <div class="tab-pane fade show active" id="approved-candidates-content{{ $demand->id }}">
                                                                <table class="table table-bordered dt-responsive nowrap" id="approvedCandidatesTable{{ $demand->id }}">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="select-all"></th>
                                                                        <th>S.N</th>
                                                                        <th>Status</th>
                                                                        <th>Full Name</th>
                                                                        <th>Gender</th>
                                                                        <th>Passport No</th>
                                                                        <th>Expire Date</th>
                                                                        <th>Experience</th>
                                                                        <th>Address</th>
                                                                        <th>Age</th>
                                                                        <th>Height</th>
                                                                        <th>Weight</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div class="tab-pane fade" id="interview-candidates-content{{ $demand->id }}">
                                                                <table class="table table-bordered dt-responsive nowrap" id="interviewCandidatesTable{{ $demand->id }}">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="select-all"></th>
                                                                        <th>S.N</th>
                                                                        <th>Status</th>
                                                                        <th>Full Name</th>
                                                                        <th>Gender</th>
                                                                        <th>Passport No</th>
                                                                        <th>Expire Date</th>
                                                                        <th>Experience</th>
                                                                        <th>Address</th>
                                                                        <th>Age</th>
                                                                        <th>Height</th>
                                                                        <th>Weight</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            @empty

                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@forelse($demands as $demand)

    @push('scripts')
        <!-- Select extension JS -->
        <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

        <script>

            $(document).ready(function() {
                // Initialize DataTables for approved candidates
                let approvedCandidatesUrl = "{{ route('manager.approved.candidate.demandCandidates', ':demandCode') }}".replace(':demandCode', '{{ $demand->demand_code }}') + '?type=approved';
                initDataTable('approvedCandidatesTable{{ $demand->id }}', approvedCandidatesUrl);

                // Adjust DataTables when a tab is shown
                adjustDataTablesOnTabShown();
            });

            function adjustDataTablesOnTabShown() {
                $('a[data-bs-toggle="list"]').on('shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust().responsive.recalc();
                });
            }

            function initDataTable(tableId, ajaxUrl) {
                $('#' + tableId).DataTable({
                    "bAutoWidth": false,
                    "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
                    "pageLength": 50,
                    "processing": true,
                    "serverSide": true,
                    "responsive": true, // Make sure tables are responsive
                    "ajax": {
                        "url": ajaxUrl,
                        "type": "GET",
                    },
                    "columns": [
                        {
                            "data": null, // Use null for the checkbox column
                            "defaultContent": '', // No content
                            "className": 'select-checkbox', // Needed for Select to target the column
                            "orderable": false,
                            "searchable": false
                        },
                        {"data": "DT_RowIndex", searchable: false, orderable: false},
                        {"data": "demand_status"},
                        {"data": "full_name"},
                        {"data": "gender"},
                        {"data": "passport_number"},
                        {"data": "expiry_date"},
                        {"data": "total_work_experience"},
                        {"data": "permanent_address"},
                        {"data": "age"},
                        {"data": "height"},
                        {"data": "weight"},
                        {"data": "action", searchable: true, orderable: true},
                    ],
                    initComplete: function() {
                        var api = this.api();
                        api.columns([1,3]).every(function() {
                            var column = this;
                            var select = $('<select><option value="">All Item</option></select>')
                                .appendTo($(column.header()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            column.data().unique().sort().each(function(d) {
                                if(d) { // Ensuring non-null, non-undefined values
                                    select.append(`<option value="${d}">${d}</option>`);
                                }
                            });
                        });
                    },
                    "select": {
                        "style": 'multi', // Enable multiple selection
                        "selector": 'td:first-child' // Use the first column for selection
                    },
                    "order": [[1, 'asc']] // Adjust column ordering as needed

                   });

                // Handle click on "Select all" control
                $('#select-all').on('click', function(){
                    // Get all rows with search applied
                    var rows = table.rows({ 'search': 'applied' }).nodes();
                    // Check/uncheck checkboxes for all rows in the table
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                });

                // Handle checkbox change event to select/deselect rows
                $('#approvedCandidatesTable{{ $demand->id }} tbody').on('change', 'input[type="checkbox"]', function(){
                    // If checkbox is not checked
                    if(!this.checked){
                        var el = $('#select-all').get(0);
                        // If "Select all" control is checked and has 'indeterminate' property
                        if(el && el.checked && ('indeterminate' in el)){
                            el.indeterminate = true;
                        }
                    }
                });

                $('a[data-bs-toggle="list"]').on('shown.bs.tab', function(e) {
                    table.columns.adjust().responsive.recalc().draw();
                });
            }
        </script>

        <script>
            $(document).ready(function() {
                // Initialize DataTables for matched candidates
                let interviewCandidatesUrl = "{{ route('manager.interview.candidate.demandCandidates', ':demandCode') }}".replace(':demandCode', '{{ $demand->demand_code }}') + '?type=interview';
                initDataTable('interviewCandidatesTable{{ $demand->id }}', interviewCandidatesUrl);

                // Adjust DataTables when a tab is shown
                adjustDataTablesOnTabShown();
            });

            function adjustDataTablesOnTabShown() {
                $('a[data-bs-toggle="list"]').on('shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust().responsive.recalc();
                });
            }

            function initDataTable(tableId, ajaxUrl) {
                $('#' + tableId).DataTable({
                    "bAutoWidth": false,
                    "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
                    "pageLength": 50,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": ajaxUrl,
                        "type": "GET",
                    },
                    "columns": [
                        {
                            "data": null, // Use null for the checkbox column
                            "defaultContent": '', // No content
                            "className": 'select-checkbox', // Needed for Select to target the column
                            "orderable": false,
                            "searchable": false
                        },
                        {"data": "DT_RowIndex", searchable: false, orderable: false},
                        {"data": "interview_status"},
                        {"data": "full_name"},
                        {"data": "gender"},
                        {"data": "passport_number"},
                        {"data": "expiry_date"},
                        {"data": "total_work_experience"},
                        {"data": "permanent_address"},
                        {"data": "age"},
                        {"data": "height"},
                        {"data": "weight"},
                        {"data": "action", searchable: true, orderable: true},
                    ],
                    "select": {
                        "style": 'multi', // Enable multiple selection
                        "selector": 'td:first-child' // Use the first column for selection
                    },
                    "order": [[1, 'asc']] // Adjust column ordering as needed

                });

                // Handle click on "Select all" control
                $('#select-all').on('click', function(){
                    // Get all rows with search applied
                    var rows = table.rows({ 'search': 'applied' }).nodes();
                    // Check/uncheck checkboxes for all rows in the table
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                });

                // Handle checkbox change event to select/deselect rows
                $('#approvedCandidatesTable{{ $demand->id }} tbody').on('change', 'input[type="checkbox"]', function(){
                    // If checkbox is not checked
                    if(!this.checked){
                        var el = $('#select-all').get(0);
                        // If "Select all" control is checked and has 'indeterminate' property
                        if(el && el.checked && ('indeterminate' in el)){
                            el.indeterminate = true;
                        }
                    }
                });

                $('a[data-bs-toggle="list"]').on('shown.bs.tab', function(e) {
                    table.columns.adjust().responsive.recalc().draw();
                });


            }
        </script>

        <script>
            $(document).ready(function() {
                // Assuming your DataTable is initialized like this:
                // var table = $('#myDataTable').DataTable();

                $('#confirmUpdateStatus').on('click', function() {
                    // Retrieve the interview details from the form
                    var interviewDate = $('#interviewDate').val();
                    var interviewTime = $('#interviewTime').val();
                    var interviewVenue = $('#interviewVenue').val();

                    $.ajax({
                        url: '{{ route("users.update.status.notify") }}', // Ensure this route is correctly defined in your Laravel routes
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token is required for Laravel POST requests
                            interview_date: interviewDate,
                            interview_time: interviewTime,
                            interview_venue: interviewVenue
                        },
                        success: function(response) {
                            // Handle success - close modal, maybe refresh part of your page or show a success message
                            $('#updateStatusModal').modal('hide');
                            // Reload the DataTable
                            $('#myDataTable').DataTable().ajax.reload(null, false); // false means do not reset the paging
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            alert('An error occurred. Please try again.');
                        }
                    });
                });
            });
        </script>





    @endpush

@empty



@endforelse
