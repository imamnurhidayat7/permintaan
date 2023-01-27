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
                    <form action="{{url('tambah-email')}}" method="post" class="myForm" enctype="multipart/form-data">@csrf
                    <div class="row mt-4 py-4">
                        <div class="col-md-12 mb-2">
                            <label for="">Jenis Layanan*</label>
                            <select name="jenis" id="type" class="form-control" required>
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="Pendaftaran Email Baru">Pendaftaran Email Baru</option>
                                <!-- <option value="Reset Password Email">Reset Password Email</option> -->
                                <!-- <option value="Penghapusan Email">Penghapusan Email</option> -->
                                <option value="Penonaktifan Email">Penonaktifan Email</option>
                            </select>
                        </div>
                        <div id="pendaftaran">
                            <div class="col-md-12 mb-2">
                                <label for="">NIP (Jika lebih dari 1 pisahkan dengan koma tanpa spasi)*</label>
                                <input type="text" name="nip" class="form-control" required>
                            </div>
                        </div>
                        <div id="reset">
                            <div class="col-md-12 mb-2">
                                <label for="">Email*</label>
                                <input type="text" name="email" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Surat Rekomendasi / Nota Dinas*</label>
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
        $('#pendaftaran').hide();
        $('#reset').hide();
        $('#hapus').hide();
        $('#suspend').hide();
        
        $('#type').on('change', function(){
            var type = $(this).val();

            if(type == ''){
                $('#pendaftaran').hide().find(':input').prop('readonly', true);
                $('#reset').hide().find(':input').prop('readonly', true);
            }
            else if(type == 'Pendaftaran Email Baru'){
                $('#pendaftaran').show().find(':input').prop('readonly', false);
                $('#reset').hide().find(':input').prop('readonly', true);
            }
            else{
                $('#pendaftaran').hide().find(':input').prop('readonly', true);
                $('#reset').show().find(':input').prop('readonly', false);
            }
            
        });
    </script>
    @endsection
    </body>
</html>
