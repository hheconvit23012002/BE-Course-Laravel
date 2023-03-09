<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Register - Sign Up | Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->

    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body class="authentication-bg" data-layout-config='{"darkMode":false}'>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Free Sign Up</h4>
                        </div>
                        <form action="{{ route('process_signup') }}" method="POST" id="form-signup">
                            @csrf

                            <div class="form-group">
                                <label for="fullname">Full Name</label>
                                @if($errors->any('name'))
                                    <span class="error">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}"
                                       id="fullname" placeholder="Enter your name" required>
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">Email address</label>
                                @if($errors->any('email'))
                                    <span class="error">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}"
                                       id="emailaddress" required placeholder="Enter your email">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                @if($errors->any('password'))
                                    <span class="error">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="password" value="{{ old('password') }}"
                                           class="form-control" placeholder="Enter your password">
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary"> Sign Up</button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Already have account? <a href="{{ route('login') }}"
                                                                       class="text-muted ml-1"><b>Log In</b></a></p>
                    </div> <!-- end col-->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    2018 - 2020 © Hyper - Coderthemes.com
</footer>

<script src="{{ asset('js/vendor.min.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#form-signup').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route('process_signup') }}',
                type: 'POST',
                data: $(this).serialize(),
                success : function(response){
                    window.location.href = '/login';
                },
                error: function (response) {
                    $.toast({
                        heading: 'Server Error',
                        text: "Sai email hoac mat khau",
                        showHideTransition: 'slide',
                        position: 'top-right',
                        icon: 'error'
                    })
                }
            })
        })
    });
</script>
</body>
</html>
