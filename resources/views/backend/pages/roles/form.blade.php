@extends('backend.layout')

@section('title')
Roles | {{ config('app.name') }}
@endsection

@section('content')

<style>
    .table th,
    .table td {
        border: 1px solid #dee2e6;
        padding: 5px 10px;
    }

    .table th {
        font-weight: 500;
    }

    .status-check span {
        display: block;
        color: #dc3b05;
        margin-bottom: 10px;
    }

    tr.table-name {
        background: #f6f6f6;
    }

    tr.table-name td {
        padding: 20px;
    }

    .form-check.check-all {
        margin-bottom: 0 !important;
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
                    <h5 class="mb-0">Edit Role permissions</h5>
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
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-color">
                    <h5 class="card-title m-0">Role details</h5>
                </div>
                <div class="card-body">
                    <form id="addRoleForm" class="row" method="POST" action="{{ route('user.updateRole', $role->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="col-12">
                            <label for="modalRoleName">Role Name:</label>
                            <input type="text" id="modalRoleName" name="name" value="{{ $role->name }}"
                                class="form-control" placeholder="Enter role name" tabindex="-1"
                                data-msg="Please enter role name" {{ $role->id == 1 ? 'readonly' : '' }} />
                            @error('name')
                            <p class="form-text text-danger">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-12">
                            <h5 class="mt-2 pt-50">Role Permissions</h5>
                            @error('permission')
                            <p class="form-text text-danger">
                                {{ $message }}</p>
                            @enderror
                            <!-- Permission table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr class="table-name">
                                            <td class="text-nowrap fw-medium">Administrator Access</td>
                                            <td>
                                                <div class="form-check check-all">
                                                    <input class="form-check-input" type="checkbox" id="selectAll" />
                                                    <label class="form-check-label" for="selectAll">Select All</label>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($permissions as $key => $item)
                                        <tr>
                                            <td class="text-nowrap fw-bolder text-capitalize">
                                                <input class="form-check-input group-check ms-2 absolute-check"
                                                    type="checkbox" data-category="{{ $key }}" />
                                                <label class="form-check-label">
                                                    {{ $key }}
                                                </label>
                                            </td>
                                            @foreach ($item as $permission)
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permission[]"
                                                        value="{{ $permission->id }}" {{ in_array($permission->id,
                                                    $selectedPermissions) ? 'checked' : null }} />
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Permission table -->
                        </div>
                        <div class="col-12 text-center mt-10 mb-5">
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                            <a href="{{ route('user.roles') }}"><button class="btn btn-outline-secondary">
                                    Discard
                                </button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#selectAll').on('change', function() {
        var value = $(this).is(':checked');
        $('input[name="permission[]"]').prop('checked', value);

    })
    $('.group-check').on('change', function() {
        var value = $(this).is(':checked');
        $(this).closest('tr').find('input[type="checkbox"]').prop('checked', value);
    })
</script>
@endpush