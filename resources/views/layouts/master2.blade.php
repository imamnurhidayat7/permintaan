<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pusdatin ATR/BPN</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/css/datatables.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Icons Css -->
        <link href="{{ URL::asset('/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ URL::asset('/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Styles -->
    </head>
    <body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar" class="py-2">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{url('/')}}" class="logo">
                            <span class="logo-sm">
                                <img src="{{url('')}}/images/logo.png" alt="" width="40">
                            </span>
                            <span class="logo-lg">
                                <img src="{{url('')}}/images/logo.png" alt="" width="40">
                            </span>
                            <span class="text-white" style="margin-left:10px; font-size:18px;">Pusdatin ATR/BPN</span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                
                </div>
                <div class="d-flex">
                    @if(!Auth::user())
                    <div class="dropdown d-none d-lg-inline-block ml-1">
                        <a href="{{url('login')}}"><button type="button" class="btn btn-sm btn-primary">
                            Masuk
                        </button>
                        </a>
                    </div>
                    @else
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @include('layouts.foto')
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst(Auth::user()->name)}}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            @if(Session::get('role') != '' && Session::get('role') != 'pemohon' )
                            <a class="dropdown-item" href="{{url(Session::get('role').'/dashboard')}}"><i class="bx bx-home font-size-16 align-middle me-1"></i><span key="t-dashboard"> Dashboard</span></a>
                            @endif
                            <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Keluar</span></a>
                            <form id="logout-form" action="{{ url('signout') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @endif
                    
                </div>
            </div>
        </header>

        <div class="main-content" style="background-color:F2F4F7;">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @include('sweetalert::alert')
                    @yield('content')
                </div> <!-- content -->
            </div>
            
        </div>
    </div>

    <script src="{{ URL::asset('libs/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('libs/bootstrap.min.js')}}"></script>
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/js/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Datatable init js -->
    <script>
        $('#datatable').DataTable();

        $('.select2').select2();
    </script>
    @include('layouts.pusher')
    @yield('script')
    </body>
</html>
