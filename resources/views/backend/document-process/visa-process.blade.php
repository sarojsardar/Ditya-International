<div class="table-responsive">
    @role(['Company'])
    @else
    <form action="{{ route('document-process.uploadMassVisaDocument') }}" method="GET" id="mass-visa-upload-form">
        @csrf
        <input type="hidden" id="visa-candidates" name="visa_documents">
    </form>
    <button id="visa_upload_btn" class="btn btn-sm btn-primary mb-3 ml-3" onclick="proceedVisaUpload()" hidden><i class='fas fa-cloud-upload-alt'></i> Upload Visa Document</button>
    @endrole
    <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="visa-process-datatable">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAllVisaDocuments" onchange="selectAllVisaDocuments()" style="cursor: pointer">
                </th>
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
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            let demandId = @json($demand->id);
            let url = '{{route('document-process.visaProcessCandidates', ':id')}}'
            url = url.replace(':id', demandId)

            $('#visa-process-datatable').DataTable({
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
                    {'data' : 'checkbox'},
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
                    $('#visa-process-count').html(numRows)
                },
                "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false,
                }]
            })
        })

        $(document).on('change', '.visaDocumentCheck', function() {
            triggerUploadBtn();
        });   
        
        function triggerUploadBtn(){
            let documents = [];
            $('.visaDocumentCheck:checked').each(function (i) {
                documents.push($(this).val());
            });
            if(documents.length > 0){
                $('#visa_upload_btn').removeAttr('hidden', 'hidden');
            }else{
                $('#visa_upload_btn').attr('hidden', 'hidden');
            }        
        }

        function selectAllVisaDocuments(){
            let selectAll = document.getElementById('selectAllVisaDocuments');
            let checks = document.querySelectorAll('.visaDocumentCheck');
            if(selectAll.checked){
                checks.forEach(function (item) {
                    item.checked = true;
                })
            }else {
                checks.forEach(function (item) {
                    item.checked = false;
                })
            }

            triggerUploadBtn();
        }

        function proceedVisaUpload(){
            let documents = [];
            $('.visaDocumentCheck:checked').each(function (i) {
                documents.push($(this).val());
            });
            if(documents.length == 0){
                alertify.error('Please select candidates')
                return '';
            }        
            let btn = event.target;

            alertify.confirm("Are you sure to continue", function (ev) {
                ev.preventDefault();
                btn.innerHTML = 'Processing..';

                $('#visa-candidates').val(documents);
                $('#mass-visa-upload-form').submit();
               
            }, function(ev) {
                ev.preventDefault();
                return '';
            });
        }

    </script>
@endpush