

@extends('layouts.master2')

@section('content')
<div class="container">
<form action="{{url('tambah-absen')}}" method='post' class="outer-repeater myForm" enctype="multipart/form-data">@csrf
        <div class="row">
            <h2 class="text-center mt-4 mb-4">Pendaftaran Pusdatin Menyapa</h2>
            <div class="col-md-6 mb-2">
                <label for="">Nama Depan*</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-2">
                <label for="">Nama Belakang*</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="col-md-12 mb-2">
                <label for="">Email Zoom*</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            <div class="col-md-12 mb-2">
                <label for="">Kantor*</label>
                <select name="kantor" id="kategori" class="form-control select2" required>
                    <option value="{{Session::get('kantor')}}">{{Session::get('kantor')}}</option>
                </select>
            </div>
            <div class="col-md-12 mb-2 text-center">
            <button type="submit" class="submit btn btn-md btn-primary mt-4">Submit</button>
            </div>
        </div>
    </div>
            
</form>
@endsection

    