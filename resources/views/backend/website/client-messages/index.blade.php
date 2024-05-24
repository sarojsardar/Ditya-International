@extends('backend.layout')

@section('title')
Client Messages | {{ config('app.name') }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-lg-12 mt-3">
            <div class="card m-b-30">
                <div class="card-header card-header-color">
                    Client Messages
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="client-message-datatable">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Message</th>
                                    <th>Sent Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#client-message-datatable').DataTable({
                "bAutoWidth":false,
                "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
                "pageLength": 50,
                "processing": true,
                "severside": true,
                ajax: {
                    url: '{{ route('client.index') }}',
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
                    {'data' : 'status'},
                    {'data' : 'name'},
                    {'data' : 'subject'},
                    {'data' : 'email'},
                    {'data' : 'contact'},
                    {'data' : 'message'},
                    {'data' : 'sent_date'},
                    {'data' : 'action'},
                ],
                "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false,
                }]
            })
        })

        function markMessageRead(id){
            let url = '{{ route('client.message.markRead', ':id') }}'
            url = url.replace(':id', id)

            let btn = event.currentTarget;

            $.ajax({
                url: url,
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                beforeSend: function(){
                    btn.innerHTML = 'Processing..'
                },
                // complete: function(){
                //     btn.innerHTML = "<i class='las la-check-double'></i> Mark Read";
                // },
                success: function(res){
                    if(res.status == 'success'){
                        alertify.success(res.message);
                        $('#client-message-datatable').DataTable().ajax.reload(null, false);
                    }else{
                        alertify.error(res.message);
                    }
                }
            })
        }
    </script>
@endpush
