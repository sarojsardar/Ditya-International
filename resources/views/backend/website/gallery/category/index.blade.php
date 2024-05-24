@extends('backend.layout')

@section('title')
Gallery Category | {{ config('app.name') }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="ri-folder-image-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Gallery Category</h5>
                    <span>Gallery Categories Information</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Gallery Category</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

        <div class="col-lg-12 mt-3">
            <div class="card m-b-30">
                <div class="card-header card-header-color d-flex align-items-center">
                    <h5>Gallery Categories</h5>
                    <a href="{{ route('website.gallery.category.create') }}">
                        <button class="btn btn-sm btn-primary" style="margin-bottom: 15px; margin-left: 10px;">
                            Add New
                        </button>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="gallery-category-datatable">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Thumbnail</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
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
            $('#gallery-category-datatable').DataTable({
                "bAutoWidth":false,
                "lengthMenu": [ [50, 100, 150, -1], [50, 100, 150, "All"] ],
                "pageLength": 50,
                "processing": true,
                "severside": true,
                ajax: {
                    url: '{{ route('website.gallery.category.index') }}',
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
                    {'data' : 'thumbnail'},
                    {'data' : 'category_name'},
                    {'data' : 'status'},
                    {'data' : 'action'},
                ],
                "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false,
                }]
            })
        })

        function toggleCategoryStatus(id){
            let url = '{{ route('website.gallery.category.toggleCategoryStatus', ':id') }}'
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
                success: function(res){
                    if(res.status == 'success'){
                        alertify.success(res.message);
                        $('#gallery-category-datatable').DataTable().ajax.reload(null, false);
                    }else{
                        alertify.error(res.message);
                    }
                }
            })
        }

        function deleteCategory(id){

            let btn = event.currentTarget;

            alertify.confirm("Are you sure to continue", function (ev) {
                ev.preventDefault();

                let url = '{{ route('website.gallery.category.deleteCategory', ':id') }}'
                url = url.replace(':id', id)

                btn.innerHTML = 'Deleting..';

                $.ajax({
                    url: url,
                    type: 'GET',
                    error: function(err){
                        console.log(err);
                    },
                    success: function(res){
                        console.log(res);
                        if(res.status == 'success'){
                            alertify.success(res.message);
                            $('#gallery-category-datatable').DataTable().ajax.reload(null, false);
                        }else{
                            alertify.error(res.message);
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
