<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? '' : 'collapsed' }}" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if(\App\Helpers\RoleHelper::isAuthorized('Secciones.showSections'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('sections.*') ? '' : 'collapsed' }}" href="{{ route('sections.index') }}">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Secciones</span>
                </a>
            </li>
        @endif

        @if(\App\Helpers\RoleHelper::isAuthorized('Servicios.showServicios'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('servicios.*') ? '' : 'collapsed' }}" href="{{ route('servicios.index') }}">
                    <i class="bi bi-newspaper"></i>
                    <span>Servicios</span>
                </a>
            </li>
        @endif

           @if(\App\Helpers\RoleHelper::isAuthorized('Roles.showRoles'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('roles.*') ? '' : 'collapsed' }}" href="{{ route('roles.index') }}">
                    <i class="bi bi-newspaper"></i>
                    <span>Roles</span>
                </a>
            </li>
        @endif
    </ul>

</aside>

