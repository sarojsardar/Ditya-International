@extends('backend.layout')

@section('title')
    Company Demands | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
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
                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered dt-responsive nowrap" id="approvedCandidatesTable{{ $demand->id }}" data-demand-code="{{ $demand->demand_code }}">
                                                    <thead>
                                                    <tr>
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


    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Print Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Loading print preview...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printDocument()">Print</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initial DataTable setup for the active tab
            initDataTableForActiveTab();

            // Reinitialize DataTables when switching tabs to ensure proper rendering and functionality
            $('a[data-bs-toggle="list"]').on('shown.bs.tab', function() {
                initDataTableForActiveTab();
            });
        });

        function initDataTableForActiveTab() {
            var activeTabPane = $('.tab-pane.active');
            var tableId = $('table', activeTabPane).attr('id');

            // Check if the DataTable instance already exists
            if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                var demandCode = $('#' + tableId).data('demand-code');
                var selectedCandidatesUrl = "{{ route('receptionist.selected.candidates', ':demandCode') }}".replace(':demandCode', demandCode) + '?type=selected';

                // Initialize DataTable with the dynamic URL and configurations
                initDataTable(tableId, selectedCandidatesUrl);
            } else {
                // If the DataTable instance exists, simply redraw and adjust
                var table = $('#' + tableId).DataTable();
                table.columns.adjust().responsive.recalc().draw();
            }
        }

        function initDataTable(tableId, ajaxUrl) {
            $('#' + tableId).DataTable({
                "bAutoWidth": false,
                "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
                "pageLength": 50,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": ajaxUrl,
                    "type": "GET",
                },
                "columns": [
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
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            return `
                            <button class="btn btn-success btn-sm" onclick="updateCandidateStatus(${data}, 'New','${tableId}')">Move to Medical</button>
                        `;
                        }
                    },
                ],
                "initComplete": function() {
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
                            if (d) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            }
                        });
                    });
                }
            });
        }

        function updateCandidateStatus(candidateId, medical_status, tableId) {
            $.ajax({
                url: '{{ route("update-candidate-status") }}', // This route needs to be defined in your web.php
                method: 'POST',
                data: {
                    id: candidateId,
                    medical_status: medical_status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Status updated successfully.');
                    $('#' + tableId).DataTable().ajax.reload(null, false); // Reload data without resetting pagination
                },
                error: function() {
                    alert('Error updating status');
                }
            });
        }
    </script>



@endpush

