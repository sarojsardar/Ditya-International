<div class="table-responsive">
    <button id="approve_btn" class="btn btn-sm btn-primary mb-3 ml-3" onclick="approveSelectedCandidates()" hidden><i class='fa fa-thumbs-up'></i> Approve Selected Candidates</button>
    <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="documents-datatable">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAllDocuments" onchange="selectAllDocuments()" style="cursor: pointer">
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
                <th>Document Upload Date</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            let demandId = @json($demand->id);
            let url = '{{route('document-process.newApprovedCandidatesDocuments', ':id')}}'
            url = url.replace(':id', demandId)

            $('#documents-datatable').DataTable({
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
                    {'data' : 'document_upload_date'},
                    {'data' : 'action'},
                ],
                "initComplete": function (settings, json) {
                    let api = this.api();
                    let numRows = api.rows().count();
                    $('#documentation-count').html(numRows)
                },
                "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false,
                }]
            })
        })

        $(document).on('change', '.documentCheck', function() {
            triggerApproveBtn();    
        });  
        
        function triggerApproveBtn(){
            let documents = [];
            $('.documentCheck:checked').each(function (i) {
                documents.push($(this).val());
            });
            if(documents.length > 0){
                $('#approve_btn').removeAttr('hidden', 'hidden');
            }else{
                $('#approve_btn').attr('hidden', 'hidden');
            }   
        }

        function selectAllDocuments(){
            let selectAll = document.getElementById('selectAllDocuments');
            let checks = document.querySelectorAll('.documentCheck');
            if(selectAll.checked){
                checks.forEach(function (item) {
                    item.checked = true;
                })
            }else {
                checks.forEach(function (item) {
                    item.checked = false;
                })
            }
            triggerApproveBtn();
        }

        function approveSelectedCandidates(){
            let documents = [];
            $('.documentCheck:checked').each(function (i) {
                documents.push($(this).val());
            });
            if(documents.length == 0){
                alertify.error('Please select documents')
                return '';
            }

        
            let btn = event.target;

            alertify.confirm("Are you sure to continue", function (ev) {
                ev.preventDefault();
                btn.innerHTML = 'Approving..';

                let formData = new FormData();
                formData.append('documents', documents);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('document-process.massDocumentSubmit') }}',
                    type: 'POST',
                    data: formData,
                    error: function(err){
                        console.log(err);
                    },
                    complete: function(){
                        btn.innerHTML = "<i class='fa fa-thumbs-up'></i> Approve Selected Candidates";
                        $('#approve_btn').attr('hidden', 'hidden');
                    },
                    success: function(res){
                        if(res.status == 'success'){
                            alertify.success(res.message)
                            refreshDatatables()
                            countDocumentRecord()
                        }else {
                            alertify.error(res.message)
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
               
            }, function(ev) {
                ev.preventDefault();
                return '';
            });
        }

        function submitDocument(id){
            let url = '{{ route('document-process.approveDocument', ':id') }}'
            url = url.replace(':id', id)

            let btn = event.target;

            alertify.confirm("Are you sure to continue", function (ev) {
                ev.preventDefault();
                btn.innerHTML = 'Approving..';

                $.ajax({
                    url: url,
                    type: 'GET',
                    error: function(err){
                        alertify.error('Error! Please check PRO quota management before approving')
                        console.log(err);
                    },
                    complete: function(){
                        btn.innerHTML = '<i class="fa fa-thumbs-up"></i> Approve Candidate';
                    },
                    success: function(res){
                        if(res.status == 'success'){
                            alertify.success(res.message)
                            refreshDatatables()
                            countDocumentRecord()
                        }else {
                            alertify.error(res.message)
                        }
                        }
                    })
               
            }, function(ev) {
                ev.preventDefault();
                return '';
            });
        }
    </script>
@endpush