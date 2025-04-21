<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo mx-auto">
                <img src="/ibpo_logo.svg" alt="" width="60%">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : ''}}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Báo cáo</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        @can('general-check', ['Customer Management', 'viewAny'])
        <li class="menu-item {{ request()->routeIs('customers.index') ? 'active' : ''}}">
            <a href="{{ route('customers.index') }}" class="menu-link">
                <i class='bx bx-user menu-icon tf-icons'></i>
                <div data-i18n="Misc">Quản lý khách hàng</div>
            </a>
        </li>
        @endcan
        @can('general-check', ['Contract Management', 'viewAny'])
        <li class="menu-item {{ request()->routeIs('contracts.index') ? 'active' : ''}}">
            <a href="{{ route('contracts.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Quản lý hợp đồng</div>
            </a>
        </li>
        @endcan
        @can('general-check', ['User Management', 'viewAny'])
        <li class="menu-item {{ request()->routeIs('staffs.index') ? 'active' : ''}}">
            <a href="{{ route('staffs.index') }}" class="menu-link">
                <i class='bx bxs-user menu-icon tf-icons'></i>
                <div data-i18n="Misc">Quản lý người dùng</div>
            </a>
        </li>
        @endcan
        @php
            $canViewRole = auth()->user()->can('general-check', ['Role Management', 'viewAny']);
            $canViewAction = auth()->user()->can('general-check', ['Action Management', 'viewAny']);
            $canViewPermission = auth()->user()->can('general-check', ['Permission Management', 'viewAny']);
        @endphp
        @if ($canViewRole || $canViewAction || $canViewPermission)
        <li class="menu-item {{ request()->routeIs('roles.index') || request()->routeIs('actions.index') || request()->routeIs('permissions.index') ? 'active' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Phân quyền</div>
            </a>
            <ul class="menu-sub">
                @can('general-check', ['Role Management', 'viewAny'])
                <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : ''}}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <div data-i18n="Basic">Vai trò</div>
                    </a>
                </li>
                @endcan
                @can('general-check', ['Action Management', 'viewAny'])
                <li class="menu-item {{ request()->routeIs('actions.index') ? 'active' : ''}}">
                    <a href="{{ route('actions.index') }}" class="menu-link">
                        <div data-i18n="Basic">Hành động</div>
                    </a>
                </li>
                @endcan
                @can('general-check', ['Permission Management', 'viewAny'])
                <li class="menu-item {{ request()->routeIs('permissions.index') ? 'active' : ''}}">
                    <a href="{{ route('permissions.index') }}" class="menu-link">
                        <div data-i18n="Basic">Quyền</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
    </ul>
</aside>
