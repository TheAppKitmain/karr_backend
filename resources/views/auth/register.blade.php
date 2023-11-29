<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    <!-- admin style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.css') }}">
    <style>
        .signup-form{
            overflow-y: scroll;
        }
    </style>
    
</head>

<body class="skin-blue">
    <div class="wrapper">
        <section class="sign-up-screen">
            <div class="signup-form" >
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="welocme-to-login">
                        <h3>Let's Create Your Account</h3>
                        <p>It is a long established fact that a reader.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>First Name</label>
                            <input id="f_name" type="text" placeholder="First Name"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('f_name') }}" required autocomplete="name" autofocus>

                            @error('f_name')
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
                            <button type="submit">Create Account</button>
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


    </div><!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    

</body>

</html>
