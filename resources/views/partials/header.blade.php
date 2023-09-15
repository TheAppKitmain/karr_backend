<header class="main-header">
    <!-- Logo -->
    <img src="{{asset('assets/dist/img/logo.jpeg')}}" alt="logo" class="logo">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
       <span class="sr-only">Toggle navigation</span>
     </a> -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <button class="btn btn-danger" type="button">
                                <span class=" glyphicon glyphicon-search"></span>
                            </button>

                            <input type="text" class="search-query form-control" placeholder="Search">

                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown-toggle.btn-success">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>