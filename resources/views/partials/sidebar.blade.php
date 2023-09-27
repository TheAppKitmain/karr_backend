<aside class="main-sidebar">
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
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <g clip-path="url(#clip0_6_578)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M23.1628 22.3256H0.837209C0.37507 22.3256 0 22.7007 0 23.1628C0 23.6249 0.37507 24 0.837209 24H23.1628C23.6249 24 24 23.6249 24 23.1628C24 22.7007 23.6249 22.3256 23.1628 22.3256Z"
                                        fill="black"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.86057 24C5.39843 24 5.02336 23.6249 5.02336 23.1628V14.7907C5.02336 14.3286 5.39843 13.9535 5.86057 13.9535H11.442C11.9041 13.9535 12.2792 14.3286 12.2792 14.7907V23.1628C12.2792 23.6249 11.9041 24 11.442 24H14.2327C14.6948 24 15.0699 23.6249 15.0699 23.1628V0.837209C15.0699 0.37507 14.6948 0 14.2327 0H3.06988C2.60774 0 2.23267 0.37507 2.23267 0.837209V23.1628C2.23267 23.6249 2.60774 24 3.06988 24H5.86057ZM10.6048 15.6279V22.3256H6.69778V15.6279H10.6048ZM7.25592 11.4419V10.3256C7.25592 9.86344 6.88085 9.48837 6.41871 9.48837C5.95657 9.48837 5.5815 9.86344 5.5815 10.3256V11.4419C5.5815 11.904 5.95657 12.2791 6.41871 12.2791C6.88085 12.2791 7.25592 11.904 7.25592 11.4419ZM11.721 11.4419V10.3256C11.721 9.86344 11.346 9.48837 10.8838 9.48837C10.4217 9.48837 10.0466 9.86344 10.0466 10.3256V11.4419C10.0466 11.904 10.4217 12.2791 10.8838 12.2791C11.346 12.2791 11.721 11.904 11.721 11.4419ZM11.721 5.86047V4.74419C11.721 4.28205 11.346 3.90698 10.8838 3.90698C10.4217 3.90698 10.0466 4.28205 10.0466 4.74419V5.86047C10.0466 6.32261 10.4217 6.69767 10.8838 6.69767C11.346 6.69767 11.721 6.32261 11.721 5.86047ZM7.25592 5.86047V4.74419C7.25592 4.28205 6.88085 3.90698 6.41871 3.90698C5.95657 3.90698 5.5815 4.28205 5.5815 4.74419V5.86047C5.5815 6.32261 5.95657 6.69767 6.41871 6.69767C6.88085 6.69767 7.25592 6.32261 7.25592 5.86047Z"
                                        fill="black"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.1861 4.46512H20.9303C21.3924 4.46512 21.7675 4.84019 21.7675 5.30233V23.1628C21.7675 23.6249 21.3924 24 20.9303 24H15.9985C16.1191 23.7466 16.1861 23.462 16.1861 23.1628V4.46512ZM17.8605 14.7907V15.907C17.8605 16.3691 18.2356 16.7442 18.6977 16.7442C19.1598 16.7442 19.5349 16.3691 19.5349 15.907V14.7907C19.5349 14.3286 19.1598 13.9535 18.6977 13.9535C18.2356 13.9535 17.8605 14.3286 17.8605 14.7907ZM19.5349 10.3256V9.2093C19.5349 8.74716 19.1598 8.37209 18.6977 8.37209C18.2356 8.37209 17.8605 8.74716 17.8605 9.2093V10.3256C17.8605 10.7877 18.2356 11.1628 18.6977 11.1628C19.1598 11.1628 19.5349 10.7877 19.5349 10.3256Z"
                                        fill="black"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_6_578">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg> --}}
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M2.68497 12.525L8.26497 15.375C8.42997 15.4575 8.78997 15.66 8.99247 15.33C9.17997 15.0225 8.86497 14.775 8.71497 14.6625L2.21997 9.69C1.74747 9.315 1.64247 8.5875 2.00247 8.0925C2.36247 7.575 3.11247 7.425 3.62247 7.7775L10.2225 12.51C10.3425 12.6 10.6725 12.84 10.9125 12.5625C11.1525 12.3 10.89 12 10.785 11.8875L4.65747 5.4225C4.21497 4.935 4.24497 4.125 4.83747 3.5775C5.30997 3.1425 6.14247 3.1275 6.59247 3.5925L12.615 9.8625C12.705 9.9525 12.9825 10.2375 13.2675 10.0275C13.56 9.8025 13.35 9.4725 13.2975 9.345L9.55497 3.135C9.29997 2.7375 9.29247 1.92 9.98247 1.5075C10.695 1.0875 11.3775 1.5075 11.64 1.95L15.8025 8.64C16.395 9.63 17.325 10.4625 18.15 10.8525C18.7875 11.1525 19.2825 10.77 19.365 10.1025C19.4925 9.0675 19.695 7.785 20.055 6.705C20.43 5.5725 21.75 5.01 22.875 5.58L22.4925 7.0875C22.11 8.6175 22.065 10.2225 22.3275 11.7825C22.5525 13.0875 22.7775 14.7675 22.7475 16.26C22.71 18.51 21.195 19.4925 19.8375 20.715C13.98 26.0325 9.71997 18.8025 7.64247 17.775L1.60497 14.4225C1.09497 14.13 0.982468 13.4475 1.28247 12.9525C1.57497 12.4725 2.17497 12.2625 2.68497 12.525Z"
                                    fill="black"></path>
                                <path
                                    d="M21.12 5.55C21.3 5.5875 21.4725 5.64 21.645 5.7225L21.2625 7.23C20.88 8.76 20.835 10.365 21.0975 11.925C21.3225 13.23 21.5475 14.91 21.5175 16.4025C21.48 18.6525 19.965 19.635 18.6075 20.8575C17.4975 21.8625 16.4475 22.4175 15.4575 22.65C16.7925 22.6725 18.255 22.155 19.83 20.7225C21.1875 19.5 22.695 18.5175 22.74 16.2675C22.77 14.7675 22.545 13.0875 22.32 11.79C22.05 10.23 22.1025 8.625 22.485 7.095L22.8675 5.5875C22.29 5.295 21.6525 5.31 21.12 5.55Z"
                                    fill="black"></path>
                                <path
                                    d="M21.105 11.1825C21.33 12.4875 21.555 14.1675 21.525 15.66C21.4875 17.91 19.9725 18.8925 18.615 20.115C16.275 22.2375 14.19 22.3575 12.3975 21.675C14.4375 22.9125 16.9425 23.355 19.8375 20.7225C21.195 19.5 22.7025 18.5175 22.7475 16.2675C22.7775 14.7675 22.5525 13.0875 22.3275 11.79C22.065 10.23 20.835 9.6225 21.105 11.1825Z"
                                    fill="black"></path>
                                <path
                                    d="M5.36248 3.7275L12.0375 10.605C12.1275 10.695 12.405 10.98 12.69 10.77C12.9825 10.545 12.7725 10.215 12.72 10.0875L12.4275 9.6L6.59248 3.6C6.17998 3.1725 5.45998 3.15 4.97998 3.4725C5.12248 3.5325 5.24998 3.615 5.36248 3.7275Z"
                                    fill="black"></path>
                                <path
                                    d="M2.33243 7.95749L9.65243 13.2C9.78743 13.2975 10.1549 13.56 10.4174 13.2525C10.6499 13.005 10.4624 12.72 10.3349 12.57L3.68993 7.80749C3.24743 7.49999 2.61743 7.54499 2.18243 7.87499C2.23493 7.90499 2.28743 7.92749 2.33243 7.95749Z"
                                    fill="black"></path>
                                <path
                                    d="M10.4099 2.085L14.5724 8.775C15.1649 9.765 16.0949 10.5975 16.9199 10.9875C17.3624 11.1975 17.7374 11.0625 17.9549 10.74C17.1824 10.32 16.3574 9.555 15.8024 8.64L11.6399 1.95C11.3774 1.5075 10.6949 1.0875 9.98243 1.5075C9.93743 1.53 9.90743 1.56 9.86993 1.59C10.1024 1.7175 10.2974 1.8975 10.4099 2.085Z"
                                    fill="black"></path>
                                <path
                                    d="M7.84495 16.0725C8.03245 16.17 8.45995 16.4025 8.69245 16.02C8.78245 15.87 8.75995 15.7425 8.70745 15.63L2.75245 12.585C2.27995 12.345 1.75495 12.45 1.38745 12.7725L7.84495 16.0725Z"
                                    fill="black"></path>
                                <path
                                    d="M5.9025 21.645C3.7125 21.645 1.68 20.4 0.689998 18.4275C0.599998 18.2475 0.674998 18.0225 0.862498 17.925C1.05 17.835 1.275 17.91 1.365 18.09C2.25 19.845 4.0875 20.9475 6.0525 20.8875C6.2625 20.895 6.435 21.045 6.435 21.255C6.4425 21.465 6.2775 21.6375 6.0675 21.6375C6.015 21.645 5.9625 21.645 5.9025 21.645Z"
                                    fill="black"></path>
                                <path
                                    d="M5.86503 19.785C5.85003 19.785 5.84253 19.785 5.82753 19.785C4.38753 19.6425 3.10503 18.8025 2.40753 17.535C2.31003 17.355 2.37003 17.1225 2.55753 17.025C2.73753 16.9275 2.97003 16.9875 3.06753 17.175C3.64503 18.225 4.71003 18.9225 5.90253 19.0425C6.10503 19.065 6.26253 19.245 6.24003 19.455C6.21753 19.6425 6.05253 19.785 5.86503 19.785Z"
                                    fill="black"></path>
                                <path
                                    d="M18.4725 6.135C18.285 6.135 18.12 5.9925 18.0975 5.7975C17.8875 3.8475 16.545 2.175 14.685 1.5375C14.49 1.47 14.385 1.26 14.4525 1.065C14.52 0.870003 14.73 0.765003 14.925 0.832503C17.055 1.56 18.5925 3.48 18.84 5.7225C18.8625 5.925 18.7125 6.1125 18.51 6.135C18.5025 6.135 18.4875 6.135 18.4725 6.135Z"
                                    fill="black"></path>
                                <path
                                    d="M16.65 6.51C16.47 6.51 16.305 6.375 16.2825 6.1875C16.1025 5.0025 15.3525 3.975 14.2725 3.45C14.085 3.36 14.01 3.135 14.1 2.9475C14.19 2.76 14.415 2.685 14.6025 2.775C15.9 3.4125 16.8075 4.6425 17.025 6.075C17.055 6.2775 16.9125 6.4725 16.71 6.5025C16.6875 6.5025 16.6725 6.51 16.65 6.51Z"
                                    fill="black"></path>
                            </svg>
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
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M12.0001 6.39215L3.44061 13.4486C3.44061 13.4585 3.43811 13.4732 3.43311 13.4931C3.42821 13.5129 3.4256 13.5273 3.4256 13.5376V20.6829C3.4256 20.9409 3.51992 21.1645 3.70851 21.3528C3.89705 21.5411 4.12031 21.6359 4.37835 21.6359H10.0945V15.9195H13.9058V21.6361H19.6218C19.8798 21.6361 20.1034 21.5416 20.2917 21.3528C20.4803 21.1647 20.5749 20.941 20.5749 20.6829V13.5376C20.5749 13.4979 20.5695 13.468 20.5599 13.4486L12.0001 6.39215Z"
                                    fill="black"></path>
                                <path
                                    d="M23.8344 11.8408L20.5745 9.13145V3.05779C20.5745 2.91894 20.5299 2.80476 20.4403 2.71539C20.3515 2.62612 20.2373 2.58149 20.0981 2.58149H17.24C17.101 2.58149 16.9869 2.62612 16.8974 2.71539C16.8082 2.80476 16.7637 2.919 16.7637 3.05779V5.9606L13.1315 2.92369C12.8142 2.66565 12.4371 2.53665 12.0003 2.53665C11.5637 2.53665 11.1865 2.66565 10.869 2.92369L0.165418 11.8408C0.0661949 11.92 0.0118127 12.0267 0.00169755 12.1607C-0.00836549 12.2946 0.0263077 12.4115 0.105821 12.5107L1.02875 13.6123C1.10827 13.7016 1.21234 13.7562 1.34139 13.7762C1.46053 13.7862 1.57967 13.7513 1.69881 13.672L12 5.08229L22.3013 13.6719C22.3809 13.7412 22.4849 13.7757 22.614 13.7757H22.6587C22.7876 13.7561 22.8914 13.7012 22.9714 13.6121L23.8944 12.5107C23.9737 12.4113 24.0085 12.2945 23.9982 12.1605C23.988 12.0269 23.9334 11.9202 23.8344 11.8408Z"
                                    fill="black"></path>
                            </svg> --}}
                            <img src="{{ asset('assets/dist/img/driver.png') }}" width="24" height="24"
                                viewBox="0 0 24 24" alt="">
                            Drivers</span>
                    </a>

                </li>
            @endcan
            @can('ticket-list')
                <li class="treeview <?php if ($page == 'ticket') {
                    echo 'active';} ?>">
                    <a href="{{ route('tickets') }}">
                        <span>
                            <img src="{{ asset('assets/dist/img/tickets.png') }}" width="24" height="24"
                                viewBox="0 0 24 24" alt="">
                            Tickets</span>
                    </a>
                </li>
            @endcan

            {{-- @can('car-list')
                <li class="treeview <?php if ($page == 'car') {
                    echo 'active';} ?>">
                    <a href="{{ route('cars.index') }}">
                        <span>
                            <img src="{{ asset('assets/dist/img/cars.png') }}" width="24" height="24"
                                viewBox="0 0 24 24" alt="">
                            Cars</span>
                    </a>
                </li>
            @endcan --}}
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
                echo 'active';} ?>">
                <a href="{{ route('settings', Auth::user()->id) }}">
                    <span>
                        <img src="{{ asset('assets/dist/img/setting.png') }}" width="24" height="24"
                            viewBox="0 0 24 24" alt="">
                        Settings</span>
                </a>
            </li>
            <li class="treeview <?php if ($page == 'analytics') {
                echo 'active';} ?>">
                <a href="#">
                    <span>
                        <img src="{{ asset('assets/dist/img/analytics.png') }}" width="24" height="24"
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
                        <img src="{{ asset('assets/dist/img/logout.png') }}" width="24" height="24" viewBox="0 0 24 24" alt="">
                        Logout
                    </span>
                </a>
            </li>
            
        </ul>
        </div>
    </section>
    <!-- /.sidebar -->
</aside>

  
  <!-- Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            color: white;" id="confirmLogout">Logout</button>
          </div>
      </div>
    </div>
  </div>

    
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
  <script>
    // Attach a click event handler to the "Logout" button within the modal
    document.getElementById('confirmLogout').addEventListener('click', function () {
        // Submit the logout form when the "Logout" button is clicked
        document.getElementById('logout-form').submit();
    });
</script>