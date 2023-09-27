<header class="main-header">
    <!-- Logo -->
    <img src="{{ asset('assets/dist/img/logo.jpeg') }}" alt="logo" class="logo">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a> -->
        <div class="navbar-custom-menu">
            {{-- <i class="bx bx-menu" id="sidebarOpen"></i> --}}
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown-toggle.btn-success">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>
            </li>
            <li class="dropdown tasks-menu">
                <img src="{{asset('assets/dist/img/notification.svg')}}">
            </li>
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset('assets/dist/img/profile.svg')}}" class="user-image" alt="User Image">

                    </a>

                </li>
            </ul>
        </div>
    </nav>
</header>
