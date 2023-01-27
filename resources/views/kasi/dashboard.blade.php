@extends('kasi.master_kasi')

@section('content')
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Selamat Datang !</h5>
                            <!-- <p>Dashboard Permintaan Layanan Pusdatin ATR/BPN</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 mt-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="avatar-md profile-user-wid mb-4">
                        @include('layouts.foto2')
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ Str::ucfirst(Auth::user()->name) }}</h5>
                        <p class="text-muted mb-0 text-truncate">{{Session::get('jabatan')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
            <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">Semua Request</p>
                                <a href="{{url('kasi/request')}}" class="btn btn-primary mt-2 waves-effect waves-light btn-sm">Details<i class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">Tunggakan Request</p>
                                <a href="{{url('kasi/request-saya')}}" class="btn btn-primary mt-2 waves-effect waves-light btn-sm">Details<i class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <!-- end row -->
    </div>
</div>
@endsection