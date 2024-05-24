@extends('backend.layout')

@section('title')
    Change Password | {{ config('app.name') }}
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 pb-4 border-bottom mb-4">

            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center me-5 gap-4">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                            <i class="ri-lock-password-line ri-24px"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-0">Password Update</h5>
                        <span>Password Information</span>
                    </div>
                </div>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 fst-italic">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Password</a>
                    </li>
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </nav>
        </div>

        <div class="col-12 col-lg-8">
            <!-- Change Password -->
            <div class="card mb-4">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if(Session::get('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    @if(Session::get('message'))
                        <div class="alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('upatePassword', $admin->id) }}">
                        @csrf
                        <div class="row mb-4">
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="current_password"
                                            name="current_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="currentPassword">Current Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"
                                    ><i class="mdi mdi-eye-off-outline"></i
                                        ></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="pass_confirmation"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="newPassword">New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"
                                    ><i class="mdi mdi-eye-off-outline"></i
                                        ></span>
                                </div>
                            </div>

                            <div class="col-md-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="pass"
                                            name="pass_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="confirmPassword">Confirm New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"
                                    ><i class="mdi mdi-eye-off-outline"></i
                                        ></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->
        </div>
    </div>


@endsection

@push('scripts')
    <script>

        $(document).ready(function() {
            $('.select2-options').select2();
        });

        $(document).on("select2:open", () => {
            document.querySelector(".select2-container--open .select2-search__field").focus()
        });

        function setDisplayImage(event){
            var file = event.target.files;
            $('#holder').empty();
            for(i=0;i<file.length;i++){
                let url = URL.createObjectURL(file[i]);
                $('#holder').append("<img src='"+url+"' alt='profile image' style='height: 80px;width: auto;'>")
            }
        }

    </script>
@endpush
