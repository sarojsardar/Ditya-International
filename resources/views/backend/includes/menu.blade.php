<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <!-- Dashboards -->
            <li class="menu-item {{ Request::is('user/dashboard') ? 'active' : '' }}">
                <a href="{{ route('user.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <!-- Apps & Pages -->
                <li class="menu-item {{ Request::is('master-search') ? 'active' : '' }}">
                    <a href="{{ route('master.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-magnify"></i>
                        <div data-i18n="Master Search">Master Search</div>
                    </a>
                </li>

            @can(['role-read', 'role-create'])
                <li class="menu-item {{ Request::is('user/role/*') ? 'active' : '' }} {{ Request::is('user/roles*') ? 'active' : '' }} ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-shield-outline"></i>
                        <div data-i18n="Roles & Permissions">Roles & Permissions</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('user.addRole') }}" class="menu-link">
                                <div data-i18n="Add Role">Add Role</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('user.roles') }}" class="menu-link">
                                <div data-i18n="Roles List">Roles List</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can(['staff-read'])
                <li class="menu-item {{ Request::is('user/list*') ? 'active' : '' }} {{ Request::is('user/create*') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-account-group-outline"></i>
                        <div data-i18n="Staff Management">Staff Management</div>
                    </a>
                    <ul class="menu-sub">
                        @can('staff-create')
                            <li class="menu-item">
                                <a href="{{ route('staff.create') }}" class="menu-link">
                                    <div data-i18n="Add Staff">Add Staff</div>
                                </a>
                            </li>
                        @endcan

                        @can('staff-read')
                            <li class="menu-item">
                                <a href="{{ route('staff.index') }}" class="menu-link">
                                    <div data-i18n="Staff List">Staff List</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can(['company-read'])
                <li class="menu-item {{ Request::is('user/company-list') ? 'active' : '' }}  {{ Request::is('user/company/create') ? 'active' : '' }} ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-card-account-details"></i>
                        <div data-i18n="Working Companies">Working Companies </div>
                    </a>
                    <ul class="menu-sub">
                        @can('company-create')
                            <li class="menu-item">
                                <a href="{{ route('company.create') }}" class="menu-link">
                                    <div data-i18n="Add Company">Add Company</div>
                                </a>
                            </li>
                        @endcan

                        @can('company-read')
                            <li class="menu-item">
                                <a href="{{ route('company.index') }}" class="menu-link">
                                    <div data-i18n="Companies List">Companies List</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan


            @can(['webContent-read', 'webContent-create'])

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-cog"></i>
                        <div data-i18n="Options">Options </div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('categories.index') }}" class="menu-link">
                                <div data-i18n="Category Types">Category Types</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('education.types.index') }}" class="menu-link">
                                <div data-i18n="Education Types">Education Types</div>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('language.index') }}" class="menu-link">
                                <div data-i18n="Language Types">Language Types</div>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('gender.index') }}" class="menu-link">
                                <div data-i18n="Gender Types">Gender Types</div>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('year.index') }}" class="menu-link">
                                <div data-i18n="Experience Years">Experience Years</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can(['demand-read'])
            <li class="menu-item {{ Request::is('user/company-demand-entry*') ? 'active' : '' }} {{ Request::is('user/company-demand-entries*') ? 'active' : '' }}  ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-airplane"></i>
                    <div data-i18n="Company Demands">Company Demands </div>
                </a>

                <ul class="menu-sub">
                    @can(['demand-create'])
                    <li class="menu-item">
                        <a href="{{ route('company-demand.create') }}" class="menu-link">
                            <div data-i18n="Create">Create</div>
                        </a>
                    </li>
                    @endcan
                    @can(['demand-read'])
                    <li class="menu-item ">
                        <a href="{{ route('company-demand.index') }}" class="menu-link">
                            <div data-i18n="List">List</div>
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan


            @can(['all-demand-read'])
                <li class="menu-item {{ Request::is('user/match-candidates*') ? 'active' : '' }}">
                    <a href="{{route('all-demand.index')}}" class="menu-link ">
                        <i class="menu-icon tf-icons mdi mdi-account-multiple-plus"></i>
                        <div data-i18n="Match Candidates">Match Candidates </div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('user/approved-candidates*') ? 'active' : '' }}">
                    <a href="{{route('approved-demand.index')}}" class="menu-link ">
                        <i class="menu-icon tf-icons mdi mdi-account-switch"></i>
                        <div data-i18n="Approved Candidates">Approved Candidates </div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('user/interview-candidates*') ? 'active' : '' }}">
                    <a href="{{route('interview-demand.index')}}" class="menu-link ">
                        <i class="menu-icon tf-icons mdi mdi-account-switch"></i>
                        <div data-i18n="Interview Process">Interview Process </div>
                    </a>
                </li>
            @endcan


            @can(['manager-company-read'])
                <li class="menu-item {{ Request::is('user/manager/company-list*') ? 'active' : '' }}">
                    <a href="{{route('manager.company.index')}}" class="menu-link ">
                        <i class="menu-icon tf-icons mdi mdi-home-modern"></i>
                        <div data-i18n="Company List">Company List </div>
                    </a>
                </li>
            @endcan

            @can(['receptionist-company-read'])
            <li class="menu-item {{ Request::is('user/receptionist/company-list*') ? 'active' : '' }}">
                <a href="{{route('receptionist.company.index')}}" class="menu-link ">
                    <i class="menu-icon tf-icons mdi mdi-home-modern"></i>
                    <div data-i18n="Company List">Company List </div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('user/medical-process*') ? 'active' : '' }}">
                <a href="{{route('receptionist.medical.company.index')}}" class="menu-link ">
                    <i class="menu-icon tf-icons mdi mdi-home-modern"></i>
                    <div data-i18n="Medical Process">Medical Process </div>
                </a>
            </li>
            @endcan






        @can(['webContent-read', 'webContent-create'])

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-web"></i>
                        <div data-i18n="Web Management">Web Management </div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('website.slider.index') }}" class="menu-link">
                                <div data-i18n="Sliders">Sliders</div>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('website.splash.index') }}" class="menu-link">
                                <div data-i18n="Splash">Splash</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('website.services.index') }}" class="menu-link">
                                <div data-i18n="Services">Services</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('website.portfolio.index') }}" class="menu-link">
                                <div data-i18n="Portfolio">Portfolio</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('website.settings') }}" class="menu-link">
                                <div data-i18n="Settings">Settings</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('website.messageFromChairman') }}" class="menu-link">
                                <div data-i18n="Chairman Message">Chairman Message</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('website.aboutUsPage') }}" class="menu-link">
                                <div data-i18n="About">About</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('website.news.index') }}" class="menu-link">
                                <div data-i18n="News">News</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('testimonials.index') }}" class="menu-link">
                                <div data-i18n="Testimonials">Testimonials</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div data-i18n="Gallery">Gallery</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item">
                                    <a href="{{ route('website.gallery.category.index') }}" class="menu-link">
                                        <div data-i18n="Categories">Categories</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('website.gallery.images.imageSection') }}" class="menu-link">
                                        <div data-i18n="Images">Images</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endcan

        </ul>
    </div>
</aside>
