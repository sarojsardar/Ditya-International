@extends('backend.layout')

@section('title')
    Company Demands | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-end align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    @forelse($demands as $demand)
                                        @isset($demand->company_id)
                                            <a href="{{ route('manager-demand.index', $demand->company_id) }}" class="btn {{ request()->routeIs('manager-demand.index') ? 'btn-primary' : 'btn-default' }} btn-sm waves-effect waves-light">Approved Candidates</a>
                                        @endisset
                                    @empty
                                        <p>No demands available.</p> <!-- Consider showing a message or a different link when there are no demands -->
                                    @endforelse
                                </div>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-start align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                <div>
                                    @forelse($demands as $demand)
                                        @isset($demand->company_id)
                                            <a href="{{ route('manager-interview-demand.index', $demand->company_id) }}" class="btn {{ request()->routeIs('manager-demand.index') ? 'btn-default' : 'btn-primary' }} btn-sm waves-effect waves-light">Interview Selected Candidates</a>
                                        @endisset
                                    @empty
                                        <!-- Since there are no demands, provide a fallback or informative message instead -->
                                        <p>No interview demands available.</p>
                                    @endforelse

                                </div>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="list-group" id="list-tab" role="tablist">
                                    @forelse($demands as $demand)
                                        <a class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }}"
                                           id="list-demand-list{{ $demand->id }}"
                                           data-bs-toggle="list"
                                           href="#list-demand{{ $demand->id }}"
                                           role="tab">
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
                            <div class="col-md-12 col-12">
                                <div class="tab-content" id="nav-tabContent">
                                    @forelse($demands as $demand)
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="list-demand{{ $demand->id }}" role="tabpanel">
                                            <h5 class="text-light fw-medium">Candidates List of - {{ $demand->demand_code }}</h5>
                                            <form action="{{ route('users.update.status.notify') }}" method="post" id="mainForm">
                                                @csrf
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-bordered dt-responsive nowrap" id="approvedCandidatesTable{{ $demand->id }}" data-demand-code="{{ $demand->demand_code }}">
                                                        <thead>
                                                        <tr>
                                                            <th><input type="checkbox" id="select-all" onclick="selectAll(this)"></th>
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
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                                    Send Notifications
                                                </button>

                                                <!-- Modal Structure -->
                                                <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="updateStatusModalLabel">Interview Invites</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="interviewDate">Interview Date</label>
                                                                    <input type="date" class="form-control" id="interviewDate" name="interview_date">

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="interviewTime">Interview Time</label>
                                                                    <input type="time" class="form-control" id="interviewTime" name="interview_time">

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="interviewVenue">Interview Venue</label>
                                                                    <input type="text" class="form-control" id="interviewVenue" name="interview_venue">

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Approve</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    @empty
                                        <!-- Handle the empty case -->
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // DataTable initialization with dynamic loading
            initDataTableForActiveTab();

            $('a[data-bs-toggle="list"]').on('shown.bs.tab', function() {
                initDataTableForActiveTab();
            });
        });

        function initDataTableForActiveTab() {
            var activeTabPane = $('.tab-pane.active');
            var tableId = $('table', activeTabPane).attr('id');
            var demandCode = $('#' + tableId).data('demand-code');
            var selectedCandidatesUrl = "{{ route('manager.approved.candidate.demandCandidates', ':demandCode') }}".replace(':demandCode', demandCode) + '?type=selected';

            if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                initDataTable(tableId, selectedCandidatesUrl);
            } else {
                var table = $('#' + tableId).DataTable();
                table.ajax.url(selectedCandidatesUrl).load();
            }
        }

        function initDataTable(tableId, ajaxUrl) {
            $('#' + tableId).DataTable({
                "bAutoWidth": false,
                "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
                "pageLength": 50,
                "processing": true,
                "serverSide": true,
                "ajax": { "url": ajaxUrl, "type": "GET" },
                "columns": [
                    { "data": "id", "orderable": false, "searchable": false, "render": data => `<input type="checkbox" name="selectedCandidates[]" value="${data}">` },
                    { "data": "DT_RowIndex", "searchable": false, "orderable": false },
                    { "data": "demand_status" },
                    { "data": "full_name" },
                    { "data": "gender" },
                    { "data": "passport_number" },
                    { "data": "expiry_date" },
                    { "data": "total_work_experience" },
                    { "data": "permanent_address" },
                    { "data": "age" },
                    { "data": "height" },
                    { "data": "weight" },
                    { "data": "action", "searchable": true, "orderable": true }
                ],
                "initComplete": function() {
                    this.api().columns([2,4]).every(function() {
                        var column = this;
                        var select = $('<select class="form"><option value="">All</option></select>')
                            .appendTo($(column.header()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
                        column.data().unique().sort().each(function(d) {
                            select.append(`<option value="${d}">${d}</option>`);
                        });
                    });
                }
            });
        }

        function selectAll(source) {
            $(source).closest('table').find('input[type="checkbox"][name="selectedCandidates[]"]').prop('checked', source.checked);
        }

        // AJAX form submission handling
        $('#mainForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize(); // This captures all inputs except unchecked boxes

            // Explicitly add unchecked boxes with a value of 'off'
            $('input[type="checkbox"]:not(:checked)').each(function() {
                formData += `&${this.name}=off`;
            });

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#updateStatusModal').modal('hide');
                    window.location.reload();
                },
                error: function(xhr) {
                    alert(`Error: ${xhr.statusText}`);
                }
            });
        });


    </script>
@endpush
