<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-procurement.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-procurement.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light d-flex align-items-center">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-procurement.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-procurement.png') }}" alt="" height="50">
            </span>
            <span class="logo-text ms-2 d-none d-lg-block" style="color: #fff; font-size: 1.0rem; font-weight: 600;">
                SIM-Procurement
           </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                </li>
                





                {{-- products.index --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('products.index') }}">
                        <i class="ri-shopping-bag-3-line"></i> <span>Products</span>
                    </a>
                </li>

                {{-- procurements.index --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('procurements.index') }}">
                                <i class="ri-file-list-3-line"></i> <span>Procurements</span>
                            </a>
                        </li>
                    @endif
                @endauth

                {{-- procurements.report admin --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('procurements.report') }}">
                                <i class="ri-bar-chart-2-line"></i> <span>Procurement Report</span>
                            </a>
                        </li>
                    @endif
                @endauth

                                {{-- vendors.index --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('vendors.index') }}">
                        <i class="ri-user-3-line"></i> <span>Vendors</span>
                    </a>
                </li>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="menu-title"><span>Settings</span></li>
                    @endif
                @endauth

                {{-- users.index --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('users.index') }}">
                                <i class="ri-user-2-line"></i> <span>Users</span>
                            </a>
                        </li>
                    @endif
                @endauth

            

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
