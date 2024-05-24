@extends('backend.layout')

@section('title')
Roles | {{ config('app.name') }}
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center me-5 gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="tf-icons ri-shield-keyhole-line ri-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">Add a new Role</h5>
                    <span>Assign role across your platform</span>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 fst-italic">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Role</a>
                </li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-6">
        <div class="card mt-4">
            <div class="card-header card-header-color">
                <h5 class="card-title m-0">Role details</h5>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('user.storeRole') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Role Name:</label>
                        <input type="text" class="form-control" name="role">
                        @if($errors->has('role'))
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required">{{ $errors->first('role') }}</li>
                        </ul>
                        @endif
                    </div>
                    <div class="form-group mt-6">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection