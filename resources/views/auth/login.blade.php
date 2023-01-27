<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Aplikasi Buku Tamu | Pusdatin ATR/BPN</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/css/datatables.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ URL::asset('/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> -->
        <!-- App Css-->
        <link href="{{ URL::asset('/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Styles -->
  </head>
    <body>
    @include('sweetalert::alert')
    <div class="account-pages my-3 pt-sm-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Dashboard Buku Tamu Pusdatin ATR/BPN</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="{{url('/')}}" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="https://www.atrbpn.go.id/cms/assets/upload/kantor_1/kantor/20211014221502.png" alt=""
                                                    class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" method="POST" action="{{ url('signin') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email</label>
                                            <input name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="username"
                                                placeholder="Masukkan Email" autocomplete="email" autofocus>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div
                                                class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                <input type="password" name="password"
                                                    class="form-control  @error('password') is-invalid @enderror"
                                                    id="userpassword" placeholder="Masukkan password"
                                                    aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i
                                                        class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Masuk</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('libs/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('libs/bootstrap.min.js')}}"></script>
    <script>
        $("#password-addon").on('click', function () {
            if ($(this).siblings('input').length > 0) {
                $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
            }
        })
    </script>
    </body>
</html>