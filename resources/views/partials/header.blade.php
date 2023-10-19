<?php
$image = Auth::user()->image;
?>

<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}">
        <img src="{{ asset('assets/dist/img/logo.svg') }}" class="logo">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a> -->
        <div class="navbar-custom-menu">
            {{-- <i class="bx bx-menu" id="sidebarOpen"></i> --}}
            <ul class="nav navbar-nav">
                <li style="margin-top: 15px;">
                    <a style="color: #000000; text-align:bottom" >
                        {{ Auth::user()->name }}
                    </a>
                </li>
                {{-- <li class="dropdown tasks-menu">
                    <img src="{{ asset('assets/dist/img/notification.svg') }}">
                </li> --}}
                <li class="dropdown user user-menu">
                    <a href="{{ route('settings', Auth::user()->id) }}">
                        @if (isset($image))
                            <img src="{{ asset('image/' . $image) }}" class="user-image" alt="User Image">
                        @else
                            <img src="{{ asset('assets/dist/img/users.svg') }}" class="user-image" alt="User Image">
                        @endif
                    </a>

                </li>
            </ul>
        </div>
    </nav>
</header>
