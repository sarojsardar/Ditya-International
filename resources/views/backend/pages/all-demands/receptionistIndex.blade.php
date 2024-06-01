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
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-end align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                @forelse($demands as $demand)
                                @isset($demand->company_id)
                                    <a href="#" data-type="move_to_medical" data-demad_id="{{$demand->id}}" class="action-btn p-1 m-1 btn btn-sm btn-primary waves-effect waves-light">Move To Medical</a>
                                @endisset
                                @empty
                                    <p>No demands available.</p> <!-- Consider showing a message or a different link when there are no demands -->
                                @endforelse
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
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


  
    <div class="modal fade" id="move_to_medical" tabindex="-1" role="dialog" aria-labelledby="move_to_medicalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="{{route('move-to-medical')}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="move_to_medicalLabel">Move to Medical</h5>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="all_candidates" id="all_candidates" class="all_candidates">
                      <input type="hidden" name="demad_id" id="demad_id" class="demad_id">
                      <div class="form-group">
                            <label for="">Medical</label>
                            <select name="medical_id" id="medical_id" class="form-control">
                                @foreach ($medicals as $index=>$medical)
                                    <option value="{{$medical->id}}">{{$medical->name}}</option>                                    
                                @endforeach
                            </select>
                      </div>

                      <div class="form-group">
                        <label for="">Arrival Date/time</label>
                        <input type="datetime-local" class="form-control" name="checkup_date">
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Move Now</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>    
            </form>
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
                    { "data": "id", "orderable": false, "searchable": false, "render": data => `<input type="checkbox" name="selectedCandidates[]" value="${data}">` },
                    {
                        "data": "DT_RowIndex",
                        searchable: false, 
                        orderable: false
                    },
                    {
                        "data": "interview_status"
                    },
                    {
                        "data": "full_name"
                    },
                    {
                        "data": "gender"
                    },
                    {
                        "data": "passport_number"
                    },
                    {
                        "data": "expiry_date"
                    },
                    {
                        "data": "total_work_experience"
                    },
                    {
                        "data": "permanent_address"
                    },
                    {
                        "data": "age"
                    },
                    {
                        "data": "height"
                    },
                    {
                        "data": "weight"
                    },
                    {
                        "data": "id",
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


        function selectAll(source) {
            $(source).closest('table').find('input[type="checkbox"][name="selectedCandidates[]"]').prop('checked', source.checked);
        }

        // AJAX form submission handling
        function submitData(){
            var formData = $(this).serialize();
                $('input[type="checkbox"]:not(:checked)').each(function() {
                formData += `&${this.name}=off`;
            });

            formData +=`&demand_code=${$(this).data('demand_code')}`

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
        }




        $(document).on('click', '.action-btn', function(e){
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
            $('#demad_id').val($(this).data('demad_id'));
            $('#move_to_medical').modal('show');
            console.log(selectedCandidates);
        });
    </script>



@endpush

