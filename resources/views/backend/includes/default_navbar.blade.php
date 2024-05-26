<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="ri-menu-fill ri-22px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                    <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                </a>
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ri-22px"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class="ri-sun-line ri-22px me-3"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="ri-moon-clear-line ri-22px me-3"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if (@$setting->site_logo)
                        <img src="{{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }}" alt="logo"
                            height="55px" class="logo" style="object-fit: contain;">
                        @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="55px" class="logo"
                            style="object-fit: contain;">
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        @role(['Company'])
                                        @if (@auth('web')->user()?->companyInfo?->logo)
                                        <img src="{{ url('/storage/uploads/company-logo/' . auth('web')->user()?->companyInfo?->logo) }}"
                                            alt="user" class="w-px-40 h-auto rounded-circle">
                                        @else
                                        <img src="{{ asset('no-profile.jpg') }}" alt="user"
                                            class="w-px-40 h-auto rounded-circle">
                                        @endif
                                        @else
                                        @if (@auth('web')->user()?->userInfo?->profile_picture)
                                        <img src="{{ url('/storage/uploads/staff-profiles/' . auth('web')->user()?->userInfo?->profile_picture) }}"
                                            alt="user" class="w-px-40 h-auto rounded-circle">
                                        @else
                                        <img src="{{ asset('no-profile.jpg') }}" alt="user"
                                            class="w-px-40 h-auto rounded-circle">
                                        @endif
                                        @endrole
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">Hello,</span>
                                    <small class="text-muted">
                                        @if (auth('web')->user()->user_type == \App\Enum\UserTypes::COMPANY)
                                        {!! \Illuminate\Support\Str::limit(auth('web')->user()->companyInfo->name, 10,
                                        $end = '...') !!}
                                        @else
                                        @if(auth('web')->user()->hasRole(['CEO']))
                                        CEO
                                        @else
                                        {!! \Illuminate\Support\Str::limit(auth('web')->user()?->userInfo?->first_name,
                                        10, $end = '...') !!}
                                        @endif
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('profile.index')}}">
                            <i class="ri-user-3-line ri-22px me-3"></i><span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('changePassword')}}">
                            <i class="ri-lock-password-line ri-22px me-3"></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('website.settings') }}">
                            <i class="ri-settings-4-line ri-22px me-3"></i><span class="align-middle">Settings</span>
                        </a>
                    </li>

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                    <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                            <a class="btn btn-sm btn-danger d-flex" href="{{route('user.logout')}}" target="_blank">
                                <small class="align-middle">Logout</small>
                                <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
            aria-label="Search..." />
        <i class="ri-close-fill search-toggler cursor-pointer"></i>
    </div>
</nav>