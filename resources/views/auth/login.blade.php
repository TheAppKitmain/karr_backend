<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    <!-- admin style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.css') }}">


</head>
<style>
    .signup-form img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body class="skin-blue">
    <div class="wrapper">
        <section class="sign-up-screen">
            <div class="signup-form">
                <img src="{{ asset('assets/dist/img/logo.svg') }}" class="d-flex" width="100px" height="100px"
                    alt="logo">
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="welocme-to-login">
                        <h3>Welcome back!</h3>
                        <p> Log in to your account or Sign Up below.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email" type="email" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            <p class="forgot-password">Forgot password?</p>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="login-btn">
                            <button type="submit">Login</button>
                        </div>
                        <div class="alredy-have">
                            <p>Don’t have an account? <span> <a href="{{ route('register') }}">Sign Up</a></span></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <img id="randomImage" src="">
            </div>
        </section>


    </div><!-- ./wrapper -->


    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script>
        // Array of image URLs
        var imageArray = [
            '{{ asset('assets/dist/img/login/1.jpg') }}',
            '{{ asset('assets/dist/img/login/2.jpeg') }}',
            '{{ asset('assets/dist/img/login/3.jpg') }}',
            '{{ asset('assets/dist/img/login/4.jpg') }}',
            '{{ asset('assets/dist/img/login/5.jpg') }}',
        ];
       

        // Get a random index from the imageArray
        var randomIndex = Math.floor(Math.random() * imageArray.length);

        // Change the source of the image element
        document.getElementById('randomImage').src = imageArray[randomIndex];
    </script>

</body>

</html>
