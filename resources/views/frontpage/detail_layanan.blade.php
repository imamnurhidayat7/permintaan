@extends('layouts.master')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="card mini-stats-wid px-4 py-4">
                <div class="card-body">
                <a href="{{url()->previous()}}" class="btn btn-sm btn-default"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                    <div class="media mb-4 text-center">
                        <div class="media-body">
                            <h1 class="fw-large">Panduan Request {{$layanan->layanan}}</h1>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                    <div class="row mt-4 py-4">
                        <div class="col-12">
                            {!! $layanan->deskripsi !!}
                        </div>
                    </div>
                    <a href="{{url('layanan/request', $layanan->id)}}" class="btn btn-primary">Buat Request</a>
                </div>
            </div>
        </div> 
    </div>
   
    <script language="JavaScript">
    </script>
    @endsection
    </body>
</html>
