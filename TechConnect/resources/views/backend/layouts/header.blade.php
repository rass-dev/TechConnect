<nav class="navbar navbar-expand topbar tc-admin-topbar static-top">

    <button id="sidebarToggleTop" class="btn btn-link tc-burger-btn mr-2" type="button" aria-label="Toggle sidebar" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>

    <ul class="navbar-nav ml-auto align-items-center">

        <li class="nav-item dropdown no-arrow mx-1">
            @include('backend.notification.show')
        </li>

        <li class="nav-item dropdown no-arrow mx-1" id="messageT" data-url="{{ route('messages.five') }}">
            @include('backend.message.message')
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle tc-admin-user" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="tc-admin-avatar">{{ strtoupper(substr(Auth()->user()->name, 0, 1)) }}</span>
                <span class="tc-admin-user-name d-none d-lg-inline">{{ Auth()->user()->name }}</span>
                <i class="fas fa-chevron-down d-none d-lg-inline"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin-profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                </a>
                <a class="dropdown-item" href="{{ route('change.password.form') }}">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </li>

    </ul>
</nav>
