<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="fal fa-arrow-left"></i>
        </a>
        {{ __('Menu Chính') }}
        <a href="#" class="sidebar-mobile-expand">
            <i class="fal fa-expand"></i>
            <i class="fal fa-compress"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-comment-discussion"></i>
                            <span>{{ __('Thông báo') }}</span>
                            <span class="badge bg-success-400 badge-pill align-self-center ml-auto">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link" onclick="$('#logout-form').submit()">
                            <i class="fal fa-sign-out"></i>
                            <span>{{ __('Đăng xuất') }}</span>
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">
                        {{ __('Menu') }}
                        <a href="{{ route('admin.designs.index') }}" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block menu-nav">
                            <i class="fal fa-bars"></i>
                        </a>
                    </div>
                    <i class="fal fa-bars navbar-nav-link sidebar-control sidebar-main-toggle" title="{{ __('Menu') }}"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.designs.index') }}" class="nav-link {{ request()->routeIs('admin.designs*') ? 'active' : null }}">
                        <i class="fal fa-home"></i>
                        <span>
                            {{ __('Thiết kế') }}
                        </span>
                    </a>
                </li>


                @can('products.view')
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}"
                           class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : null }}">
                            <i class="fal fa-tshirt"></i>
                            <span>
                            {{ __("Sản phẩm") }}
                        </span>
                        </a>
                    </li>
                @endcan

                @can('produces.view')
                    <li class="nav-item">
                        <a href="{{ route('admin.produces.index') }}"
                           class="nav-link {{ request()->routeIs('admin.produces*') ? 'active' : null }}">
                            <i class="fal fa-conveyor-belt"></i>
                            <span>
                            {{ __("Sản xuất") }}
                        </span>
                        </a>
                    </li>
                @endcan

                @can('brands.view')
                    <li class="nav-item">
                        <a href="{{ route('admin.brands.index') }}"
                           class="nav-link {{ request()->routeIs('admin.brands*') ? 'active' : null }}">
                            <i class="fal fa-copyright"></i>
                            <span>
                            {{ __("Xưởng") }}
                        </span>
                        </a>
                    </li>
                @endcan

            <!-- System -->
                @canany(['admins.view', 'menus.index', 'log-activities.index', 'admins.view'])
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">{{ __('Hệ thống') }}</div>
                        <i class="fal fa-horizontal-rule" title="{{ __('Hệ thống') }}"></i></li>
                @endcan
                @canany(['admins.view'])
                    <li class="nav-item nav-item-submenu {{ request()->routeIs('admin.admins*') || request()->routeIs('admin.roles*') ? 'nav-item-expanded nav-item-open' : null }}">
                        <a href="#" class="nav-link"><i class="fal fa-user"></i> <span>{{ __('Tài khoản') }}</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="{{ __('Tài khoản') }}">
                            @can('admins.view')
                                <li class="nav-item"><a href="{{ route('admin.admins.index') }}"
                                                        class="nav-link @if(request()->routeIs('admin.admins*'))active @endif">{{ __('Tài khoản') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
