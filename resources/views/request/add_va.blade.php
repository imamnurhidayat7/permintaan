@extends('layouts.master')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="card mini-stats-wid px-4 py-4">
                <div class="card-body">
                    <div class="media mb-4 text-center">
                        <div class="media-body">
                            <h3 class="fw-large">Form Request {{$layanan->layanan}}</h3>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                    <form action="{{url('tambah-va')}}" method="post" class="myForm" enctype="multipart/form-data">@csrf
                    <div class="row mt-4 py-4">
                        <div class="col-md-6 mb-2">
                            <label for="">Sistem / Aplikasi*</label>
                            <input type="text" name="aplikasi" required class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">URL Aplikasi*</label>
                            <input type="text" name="url" required class="form-control">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Akun (Username dan Password)*</label>
                            <textarea name="akun" id="" cols="30" rows="3"class="form-control" required></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Surat Permohonan / Nota Dinas*</label>
                            <input type="file" name="nota_dinas" class="form-control" required accept="application/pdf" max-size="2048">
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{$layanan->id}}">
                    <button class="submit btn btn-primary" type="submit" id="submitbutton">Submit</button>
                    </form>
                </div>
            </div>
        </div> 
    </div>
   
    @endsection 
    @section('script')
    <script>
    </script>
    @endsection
    </body>
</html>
