<div class="navbar navbar-expand-md navbar-white bg-white navbar-static header-fixed">

    <div class="navbar-header navbar-white bg-white d-none d-md-flex align-items-md-center">
        <div class="navbar-brand navbar-brand-md">
            <a href="{{ route('admin.designs.index') }}" class="d-inline-block">
                    <span>{{ setting('store_name') }}</span>
            </a>
        </div>

        <div class="navbar-brand navbar-brand-xs pl-1">
            <a href="{{ route('admin.designs.index') }}" class="d-inline-block">
                <img src="{{ setting('store_favicon') ? \Storage::url(setting('store_favicon')) : '' }}" alt="">
            </a>
        </div>
    </div>

    <div class="d-flex flex-1 d-md-none">
        <div class="navbar-brand mr-auto">
            <a href="{{ route('admin.designs.index') }}" class="d-inline-block">
                <img src="{{ setting('store_favicon') ? \Storage::url(setting('store_favicon')) : '' }}" alt="">
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="fal fa-retweet"></i>
        </button>

        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="fal fa-bars"></i>
        </button>

    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav mr-md-auto">
            <li class="nav-item">
                <a href="{{ route('admin.designs.index') }}" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block header-nav">
                    <i class="fal fa-bars"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('home') }}" title="{{ setting('store_name') ?? __('Trang Chính') }}" target="_blank" class="navbar-nav-link d-none d-md-block">
                    <i class="fal fa-store"></i> {{ mb_strimwidth(setting('store_name'), 0, 35, "...") ?? __('Trang Chính') }}
                </a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ $currentUser->getFirstMediaUrl('avatar') }}" class="rounded-circle mr-2" height="34" alt="">
                    <span>{{ $currentUser->full_name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <x-form-button :action="route('admin.logout')" class="dropdown-item">
                        <i class="fal fa-sign-out"></i>
                        {{ __('Đăng xuất') }}
                    </x-form-button>
                </div>
            </li>
        </ul>
    </div>
    <!-- /navbar content -->

</div>
