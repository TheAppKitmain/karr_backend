<div>
    <aside class="main-sidebar hidden-menu">
        <section class="sidebar">
            <div class="menu_content">
                <ul class="sidebar-menu">

                    <li class="treeview <?php if ($page == 'dash') {
                        echo 'active';
                    } ?>">
                        <a href="{{ route('home') }}">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <g clip-path="url(#clip0_35_71)">
                                        <path
                                            d="M9.24994 0H1.74994C0.784973 0 0 0.784973 0 1.74994V6.24994C0 7.21509 0.784973 8.00006 1.74994 8.00006H9.24994C10.2151 8.00006 11.0001 7.21509 11.0001 6.24994V1.74994C11.0001 0.784973 10.2151 0 9.24994 0Z"
                                            fill="black"></path>
                                        <path
                                            d="M9.24994 9.99994H1.74994C0.784973 9.99994 0 10.7849 0 11.7501V22.2501C0 23.215 0.784973 24 1.74994 24H9.24994C10.2151 24 11.0001 23.215 11.0001 22.2501V11.7501C11.0001 10.7849 10.2151 9.99994 9.24994 9.99994Z"
                                            fill="black"></path>
                                        <path
                                            d="M22.2501 15.9999H14.7501C13.7849 15.9999 12.9999 16.7849 12.9999 17.7501V22.2501C12.9999 23.215 13.7849 24 14.7501 24H22.2501C23.215 24 24 23.215 24 22.2501V17.7501C24 16.7849 23.215 15.9999 22.2501 15.9999Z"
                                            fill="black"></path>
                                        <path
                                            d="M22.2501 0H14.7501C13.7849 0 12.9999 0.784973 12.9999 1.74994V12.2499C12.9999 13.2151 13.7849 14.0001 14.7501 14.0001H22.2501C23.215 14.0001 24 13.2151 24 12.2499V1.74994C24 0.784973 23.215 0 22.2501 0Z"
                                            fill="black"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_35_71">
                                            <rect width="24" height="24" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                                Dashboard</span>
                        </a>

                    </li>
                    @can('users-list')
                        <li class="treeview 
                <?php if ($page == 'user') {
                    echo 'active';
                } ?>">
                            <a href="{{ route('users.index') }}">
                                <span>

                                    <img src="{{ asset('assets/dist/img/user.png') }}" width="24" height="24"
                                        viewBox="0 0 24 24" alt="">
                                    Users
                                </span>
                            </a>
                        </li>
                    @endcan
                    {{-- @can('role-list')
                <li class="treeview">
                    <a href="{{ route('roles.index') }}">
                        <span>
                            Roles</span>
                    </a>

                </li>
            @endcan --}}
                    @can('driver-list')
                        <li class="treeview   <?php if ($page == 'driver') {
                            echo 'active';
                        } ?>">
                            <a href="{{ route('drivers.index') }}">
                                <span>
                                    <img src="{{ asset('assets/dist/img/driver.svg') }}" width="24" height="24"
                                        viewBox="0 0 24 24" alt="">
                                    Drivers</span>
                            </a>

                        </li>
                    @endcan
                    @can('admin-ticket')
                        <li class="treeview <?php if ($page == 'tickets') {
                            echo 'active';
                        } ?>">
                            <a href="{{ route('admin.tickets') }}">
                                <span>
                                    <img src="{{ asset('assets/dist/img/ticket.svg') }}" width="24" height="24"
                                        viewBox="0 0 24 24" alt="">
                                    Tickets</span>
                            </a>
                        </li>
                    @endcan
                    @can('ticket-list')
                        <li class="treeview <?php if ($page == 'tolls') {
                            echo 'active';
                        } ?>">
                            <a href="{{ route('toll') }}">
                                <span>
                                    <img src="{{ asset('assets/dist/img/paytolls.svg') }}" width="24" height="24"
                                        viewBox="0 0 24 24" alt="">
                                    Pay Tolls</span>
                            </a>
                        </li>
                    @endcan
                    @can('admin-ticket')
                    <li class="treeview <?php if ($page == 'tolls') {
                        echo 'active';
                    } ?>">
                        <a href="{{ route('admin.tolls') }}">
                            <span>
                                <img src="{{ asset('assets/dist/img/paytolls.svg') }}" width="24" height="24"
                                    viewBox="0 0 24 24" alt="">
                                Tolls & Charges</span>
                        </a>
                    </li>
                @endcan

                    @can('ticket-list')
                        <li class="treeview <?php if ($page == 'ticket') {
                            echo 'active';
                        } ?>">
                            <a href="{{ route('tickets') }}">
                                <span>
                                    <img src="{{ asset('assets/dist/img/ticket.svg') }}" width="24" height="24"
                                        viewBox="0 0 24 24" alt="">
                                    Tickets</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @can('toll-list')
                <li class="treeview <?php if ($page == 'toll') {
                    echo 'active';
                } ?>">
                    <a href="{{ route('toll') }}">
                        <span>
                            <img src="{{ asset('assets/dist/img/toll.png') }}" width="24" height="24"
                                alt="">
                            Toll</span>
                    </a>

                </li>
            @endcan --}}

                    <li class="treeview <?php if ($page == 'setting') {
                        echo 'active';
                    } ?>">
                        <a href="{{ route('settings', Auth::user()->id) }}">
                            <span>
                                <img src="{{ asset('assets/dist/img/setting.svg') }}" width="24" height="24"
                                    viewBox="0 0 24 24" alt="">
                                Settings</span>
                        </a>
                    </li>
                    <li class="treeview <?php if ($page == 'analytics') {
                        echo 'active';
                    } ?>">
                        <a href="{{ route('users.analytics') }}">
                            <span>
                                <img src="{{ asset('assets/dist/img/analytics.svg') }}" width="24" height="24"
                                    viewBox="0 0 24 24" alt="">
                                Analytics </span>
                        </a>
                    </li>


                    {{-- @can('charges-list')
                <li class="treeview   <?php if ($page == 'city') {
                    echo 'active';
                } ?>">
                    <a href="{{ route('city') }}">
                        <span>
                            <img src="{{ asset('assets/dist/img/money.png') }}" width="24" height="24"
                                alt="">
                            City Charges</span>
                    </a>

                </li>
            @endcan --}}
                    <li class="treeview">
                        <a href="#" data-toggle="modal" data-target="#logoutModal">
                            <span>
                                <img src="{{ asset('assets/dist/img/logout.svg') }}" width="24" height="24"
                                    viewBox="0 0 24 24" alt="">
                                Logout
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </section>
        <!-- /.sidebar -->
    </aside>
</div>


<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Confirm Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn" style="background-color: #8C52FF;
            color: white;"
                    id="confirmLogout">Logout</button>
            </div>
        </div>
    </div>
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<script>
    // Attach a click event handler to the "Logout" button within the modal
    document.getElementById('confirmLogout').addEventListener('click', function() {
        // Submit the logout form when the "Logout" button is clicked
        document.getElementById('logout-form').submit();
    });
</script>
