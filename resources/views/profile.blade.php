@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Profil Pegawai</h5>
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
            <div class="card py-4 px-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">NIP/NIK</label>
                        <input type="text" class="form-control" disabled value="{{$user->pegawaiid}}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Email</label>
                        <input type="text" class="form-control" disabled value="{{$user->email}}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Kantor</label>
                        <textarea name="" id="" cols="30" rows="4" disabled class="form-control">{{$user->kantor}}</textarea>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection