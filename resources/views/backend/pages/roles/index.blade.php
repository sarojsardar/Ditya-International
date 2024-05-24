@extends('backend.layout')

@section('title')
Roles | {{ config('app.name') }}
@endsection

@section('content')

<style>
    .slate-badge {
        background-color: #a7a7a7;
    }
</style>

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
                    <h5 class="mb-0">Roles List</h5>
                    <span>Roles grant tailored access to menus and features for administrators based on their assigned
                        role.</span>
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
                <li class="breadcrumb-item active">List</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-5">
                        <div class="d-flex align-items-end h-100 justify-content-center">
                            <img src="{{ asset('assets/img/illustrations/add-new-role-illustration.png') }}"
                                class="img-fluid" alt="Image" width="70" />
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap add-new-role">
                                Add Role
                            </button>
                            <p class="mb-0">Add role, if it does not exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($roles as $key => $role)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <p> Total<b> {{ $role->users_count }}</b> users </p>
                        <hr>
                        <p>Total <b>{{ $role->permissions_count }}</b> Permissions</p>

                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1 text-body">{{ $role->name }}</h4>
                            <a href="{{ route('user.editRole', $role->id) }}">
                                <span class="badge rounded-pill bg-label-secondary">Edit Role</span>
                            </a>

                        </div>

                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                title="Vinnie Mostowy" class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/img/avatars/9.png') }}"
                                    alt="Avatar" />
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
    <!--/ Role cards -->

    <!-- Add Role Modal -->
    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-role">
            <div class="modal-content">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-md-0">
                    <div class="text-center mb-6">
                        <h4 class="mb-2">Add New Role</h4>
                        <p>Set role permissions</p>
                    </div>
                    <!-- Add role form -->
                    <form id="addRoleForm" class="row g-3" action="{{ route('user.storeRole') }}" method="POST">
                        @csrf
                        <div class="col-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="modalRoleName" name="role" class="form-control"
                                    placeholder="Enter a role name" tabindex="-1" />
                                <label for="modalRoleName">Role Name</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Role Modal -->

    <!-- / Add Role Modal -->
</div>

@endsection