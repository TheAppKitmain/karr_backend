<?php

if (Auth::check()) {
    $image = Auth::user()->image;
} else {
    $image = null;
}
?>


<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}">
        <img src="{{ asset('assets/dist/img/logo_1.svg') }}" class="logo">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <button id="show-hidden-menu">
            <div id="toggle">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
        </button>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li style="margin-top: 20px;">
                    <a style="color: #000000; text-align:bottom">
                      @auth
                      {{ Auth::user()->name }}
                      @endauth
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
</header
