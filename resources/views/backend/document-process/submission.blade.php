<div class="table-responsive">
    {{-- <button class="btn btn-sm btn-primary mb-3 ml-3" onclick="approveSelectedCandidates()"><i class='fa fa-thumbs-up'></i> Approve Selected Candidates</button> --}}
    <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="documents-submission-datatable">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Candidate ID</th>             
                <th>Candidate Image</th>
                <th>Candidate Name</th>
                <th>Candidate Address</th>
                <th>Passport Number</th>
                <th>Passport Expiry</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Approved Date</th>
                <th>Document Submitted Date</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            let demandId = @json($demand->id);
            let url = '{{route('document-process.documentSubmittedCandidates', ':id')}}'
            url = url.replace(':id', demandId)

            $('#documents-submission-datatable').DataTable({
                "bAutoWidth":false,
                "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
                "pageLength": 50,
                "processing": true,
                "severside": true,
                ajax: {
                    url: url,
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
                    {'data' : 'reference_id'},
                    {'data' : 'profile'},
                    {'data' : 'full_name'},
                    {'data' : 'permanent_address'},
                    {'data' : 'passport_no'},
                    {'data' : 'passport_exp'},
                    {'data' : 'contact'},
                    {'data' : 'email'},
                    {'data' : 'approved_date'},
                    {'data' : 'document_submitted_date'},
                    {'data' : 'action'},
                ],
                "initComplete": function (settings, json) {
                    let api = this.api();
                    let numRows = api.rows().count();
                    $('#submission-count').html(numRows)
                },
            })
        })

    </script>
@endpush