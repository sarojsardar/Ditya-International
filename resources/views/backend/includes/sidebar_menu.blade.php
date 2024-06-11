<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo logo-section">
        <a href="{{route('user.dashboard')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
            {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="Diya Internatinal Logo"> --}}

                <span class="spinning-icon" style="color: var(--bs-primary)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM16.0043 12.8777C15.6589 12.3533 15.4097 11.9746 14.4622 12.1248C12.6717 12.409 12.4732 12.7224 12.3877 13.2375L12.3636 13.3943L12.3393 13.5597C12.2416 14.2428 12.2453 14.5012 12.5589 14.8308C13.8241 16.1582 14.582 17.115 14.8116 17.6746C14.9237 17.9484 15.2119 18.7751 15.0136 19.5927C16.2372 19.1066 17.3156 18.3332 18.1653 17.3559C18.2755 16.9821 18.3551 16.5166 18.3551 15.9518V15.8472C18.3551 14.9247 18.3551 14.504 17.7031 14.1314C17.428 13.9751 17.2227 13.881 17.0582 13.8064C16.691 13.6394 16.4479 13.5297 16.1198 13.0499C16.0807 12.9928 16.0425 12.9358 16.0043 12.8777ZM12 3.83333C9.68259 3.83333 7.59062 4.79858 6.1042 6.34896C6.28116 6.47186 6.43537 6.64453 6.54129 6.88256C6.74529 7.34029 6.74529 7.8112 6.74529 8.22764C6.74488 8.55621 6.74442 8.8672 6.84992 9.09302C6.99443 9.40134 7.6164 9.53227 8.16548 9.64736C8.36166 9.68867 8.56395 9.73083 8.74797 9.78176C9.25405 9.92233 9.64554 10.3765 9.95938 10.7412C10.0896 10.8931 10.2819 11.1163 10.3783 11.1717C10.4286 11.1356 10.59 10.9608 10.6699 10.6735C10.7307 10.4547 10.7134 10.2597 10.6239 10.1543C10.0648 9.49445 10.0952 8.2232 10.268 7.75495C10.5402 7.01606 11.3905 7.07058 12.012 7.11097C12.2438 7.12589 12.4626 7.14023 12.6257 7.11976C13.2482 7.04166 13.4396 6.09538 13.575 5.91C13.8671 5.50981 14.7607 4.9071 15.3158 4.53454C14.3025 4.08382 13.1805 3.83333 12 3.83333Z"></path></svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2 logo-text">
                Ditya
                <span>Int. Pvt.Ltd.</span>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                    fill-opacity="0.9" />
                <path
                    d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                    fill-opacity="0.4" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ Request::is('user/dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @can(['role-read', 'role-create'])
        <li class="menu-header mt-2">
            <span class="menu-header-text" data-i18n="users">Users</span>
        </li>

        <li
            class="menu-item {{ Request::is('user/role/*') ? 'active' : '' }} {{ Request::is('user/roles*') ? 'active' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-shield-keyhole-line"></i>

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
        <li
            class="menu-item {{ Request::is('user/list*') ? 'active' : '' }} {{ Request::is('user/create*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ri-group-line"></i>
                <div data-i18n="Staffs">Staffs</div>
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

        @can(['company-read', 'demand-read'])
        <li class="menu-header mt-2">
            <span class="menu-header-text" data-i18n="Company">Company</span>
        </li>
        @endcan

        @can(['company-read'])
        <li
            class="menu-item {{ Request::is('user/company-list') ? 'active' : '' }}  {{ Request::is('user/company/create') ? 'active' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ri-building-2-line"></i>
                <div data-i18n="Companies">Companies </div>
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

        @can(['demand-read'])
        <li
            class="menu-item {{ Request::is('user/company-demand-entry*') ? 'active' : '' }} {{ Request::is('user/company-demand-entries*') ? 'active' : '' }}  ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ri-plane-line"></i>
                <div data-i18n="Demands">Demands </div>
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

        <li
            class="menu-item {{ Request::is('user/medical*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ri-hospital-line"></i>
                <div data-i18n="Medical">Medical </div>
            </a>

            <ul class="menu-sub">
                {{-- @can(['demand-create']) --}}
                <li class="menu-item">
                    <a href="{{ route('medical.create') }}" class="menu-link">
                        <div data-i18n="Create">Create</div>
                    </a>
                </li>
                {{-- @endcan --}}
                {{-- @can(['demand-read']) --}}
                <li class="menu-item ">
                    <a href="{{ route('medical.index') }}" class="menu-link">
                        <div data-i18n="List">List</div>
                    </a>
                </li>
                {{-- @endcan --}}
            </ul>
        </li>

        @can(['all-demand-read'])

        <li class="menu-item {{ Request::is('user/match-candidates*') ? 'active' : '' }}">
            <a href="{{route('all-demand.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Match Candidates">Match Candidates</div>
            </a>
        </li>


        <li class="menu-item {{ Request::is('user/approved-candidates*') ? 'active' : '' }}">
            <a href="{{route('approved-demand.index')}}" class="menu-link">
             <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Approved Candidates">Approved Candidates </div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('user/interview-candidates*') ? 'active' : '' }}">
            <a href="{{route('interview-demand.index')}}" class="menu-link">
            <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Interview Process">Interview Process </div>
            </a>
        </li>
      @endcan


        @can(['all-demand-read', 'manager-company-read', 'receptionist-company-read'])
        <li class="menu-header mt-2">
            <span class="menu-header-text" data-i18n="Candidates">Candidates</span>
        </li>
        @endcan



        @can(['manager-company-read'])
        <li class="menu-item {{ Request::is('user/manager/company-list*') ? 'active' : '' }}">
            <a href="{{route('manager.company.index')}}" class="menu-link ">
                <i class="menu-icon ri-list-check-2"></i>
                <div data-i18n="Company List">Company List </div>
            </a>
        </li>


        @endcan

        @can(['receptionist-company-read'])
        <li class="menu-item {{ Request::is('user/receptionist/company-list*') ? 'active' : '' }}">
            <a href="{{route('receptionist.company.index')}}" class="menu-link ">
                <i class="menu-icon ri-list-indefinite"></i>
                <div data-i18n="Company List">Company List </div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('user/medical-process*') ? 'active' : '' }}">
            <a href="{{route('receptionist.medical.company.index')}}" class="menu-link ">
                <i class="menu-icon ri-heart-pulse-line"></i>
                <div data-i18n="Medical Process">Medical Process </div>
            </a>
        </li>
        @endcan


        {{-- After manag of permission we can remove this if condition --}}
        @if((int)auth()->user()->user_type == \App\Enum\UserTypes::MEDICAL_OFFICER)
        {{-- New developed for the medical officer --}}
        {{-- this permission must be managed --}}

        {{-- @can(['receptionist-company-read']) --}}
        <li class="menu-item {{ Request::is('user/medical-officer/candidate*') ? 'active' : '' }}">
            <a href="{{route('medical-officer.candidate')}}" class="menu-link ">
                <i class="menu-icon ri-list-indefinite"></i>
                <div data-i18n="All Candidate">All Candidate</div>
            </a>
        </li>
        {{-- @endcan --}}
        @endif

         {{-- After manag of permission we can remove this if condition --}}
         @if((int)auth()->user()->user_type == \App\Enum\UserTypes::DOCUMENT_OFFICER)
         {{-- New developed for the medical officer --}}
         {{-- this permission must be managed --}}

         {{-- @can(['receptionist-company-read']) --}}
         <li class="menu-item {{ Request::is('user/document-officer/candidate') ? 'active' : '' }}">
             <a href="{{route('document-officer.candidate')}}" class="menu-link ">
                <i class="menu-icon ri-list-indefinite"></i>
                <div data-i18n="All Candidate">All Candidate</div>
             </a>
         </li>
         {{-- @endcan --}}
         @endif


       {{-- After manag of permission we can remove this if condition --}}
       @if((int)auth()->user()->user_type == \App\Enum\UserTypes::COMPANY)
       {{-- New developed for the medical officer --}}
       {{-- this permission must be managed --}}

       {{-- @can(['receptionist-company-read']) --}}
       <li class="menu-item {{ Request::is('user/company/candidate') ? 'active' : '' }}">
           <a href="{{route('company-officer.candidate')}}" class="menu-link ">
              <i class="menu-icon ri-list-indefinite"></i>
              <div data-i18n="In Visa Candidate">In Visa Candidate</div>
           </a>
       </li>
       {{-- @endcan --}}
       @endif


       {{-- After manag of permission we can remove this if condition --}}
       @if((int)auth()->user()->user_type == \App\Enum\UserTypes::DOCUMENT_OFFICER)
       {{-- New developed for the medical officer --}}
       {{-- this permission must be managed --}}

       {{-- @can(['receptionist-company-read']) --}}
       <li class="menu-item {{ Request::is('user/document-officer/candidate/in-visa') ? 'active' : '' }}">
           <a href="{{route('document-officer.in-visa-candidate')}}" class="menu-link ">
              <i class="menu-icon ri-list-indefinite"></i>
              <div data-i18n="In Visa Candidate">In Visa Candidate</div>
           </a>
       </li>
       {{-- @endcan --}}
       @endif



        
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


       @can(['webContent-read', 'webContent-create'])
        <li class="menu-header mt-2">
            <span class="menu-header-text" data-i18n="Website">Website</span>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ri-global-line"></i>
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
            </ul>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ri-gallery-fill"></i>
                <div data-i18n="Gallery">Gallery </div>
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
        @endcan
    </ul>
</aside>
