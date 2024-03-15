<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ url('assets/dist/img/logo.jpeg') }}">

    <!-- admin style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.css') }}">
    <style>
        .signup-form {
            overflow-y: scroll;
        }
    </style>

</head>

<body class="skin-blue">
    <div class="wrapper">
        <section class="sign-up-screen">
            <div class="signup-form">
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="welocme-to-login">
                        <h3>Let's Create Your Account</h3>
                    </div>
                </div>
                <form method="POST" id="form" action="{{ route('register') }}">
                    @csrf
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>First Name</label>
                            <input id="name" type="text" placeholder="First Name"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="l_name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email" type="email" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Business Name</label>
                            <input type="text" class="form-control" name="business" placeholder="Business Name"
                                required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Number</label>
                            <input type="number" class="form-control" name="text" placeholder="Contact Number">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input id="password-confirm" type="password" placeholder="Confirm password"
                                class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="login-btn">
                            <button data-toggle="modal" data-target="#myModal" type="button">Create Account</button>
                        </div>
                        <div class="alredy-have">
                            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                        </div>
                    </div>
                </form>
            </div>


            <div class="signup-image">
                <img src="{{ asset('assets/dist/img/signup.png') }}" alt="">
            </div>
        </section>
        <div class="modal fade create_success_property" create_success_property="" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <div class="header_inner">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70"
                                fill="none">
                                <path
                                    d="M25.0335 35.0772C25.7627 34.5304 26.7652 34.5304 27.4944 35.0772L31.5265 38.1013L35.0715 35.4426L28.1641 23.5117V15.9875H39.2383C40.046 15.9875 40.7787 15.5132 41.1093 14.7763C41.44 14.0392 41.3071 13.1768 40.7702 12.5735L38.7023 10.2495L40.7702 7.92586C41.3072 7.32252 41.44 6.45996 41.1093 5.72305C40.7787 4.986 40.046 4.51172 39.2383 4.51172H28.1641V4.375C28.1641 3.24242 27.2459 2.32422 26.1133 2.32422C24.9807 2.32422 24.0625 3.24242 24.0625 4.375V23.5117L17.2002 35.3646L20.9826 38.1154L25.0335 35.0772Z"
                                    fill="#2D927E"></path>
                                <path
                                    d="M32.757 42.3056C32.0277 42.8525 31.0253 42.8525 30.2961 42.3056L26.2639 39.2815L22.2318 42.3056C21.8675 42.5789 21.4345 42.7158 21.0014 42.7158C20.5782 42.7158 20.1549 42.5852 19.7952 42.3235L15.1342 38.9336L0.276036 64.5975C-0.0913271 65.232 -0.0918739 66.0142 0.274122 66.6494C0.640392 67.2846 1.3177 67.6758 2.05078 67.6758H53.684L37.141 39.0174L32.757 42.3056Z"
                                    fill="#F3D55B"></path>
                                <path
                                    d="M69.6742 64.516L49.9867 33.891C49.5992 33.288 48.9285 32.9318 48.2081 32.9499C47.4916 32.9686 46.8368 33.3602 46.4811 33.9825L42.7448 40.5209L58.4199 67.6758H67.9492C68.6994 67.6758 69.3897 67.2661 69.7493 66.6077C70.1087 65.9493 70.08 65.147 69.6742 64.516Z"
                                    fill="#F3D55B"></path>
                            </svg>
                            <h2>Thanks</h2>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>Thanks for registering your interest with KARR.
                            <br>
                            A member of the team will get back to you soon.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" go-back btn btn-default" data-dismiss="modal">Go
                            back</button>
                        <button type="button" class="thanks-btn btn btn-default" data-dismiss="modal">Ok
                            register</button>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>


</body>

</html>
<script>
    $(document).ready(function() {
        $('.thanks-btn').click(function() {
            // Submit the form
            $('#form').submit(); 
        });
    });
</script>
