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
                    <form action="{{url('tambah-server')}}" method="post" class="myForm" enctype="multipart/form-data">@csrf
                    <div class="row mt-4 py-4">
                        <div class="col-md-12 mb-2">
                            <label for="">Jenis Layanan*</label>
                            <select name="jenis" id="type" class="form-control" required>
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="Layanan Pembuatan Server Virtual/Hosting">Layanan Pembuatan server virtual/hosting</option>
                                <option value="Layanan Penambahan Kapasitas Server Virtual/Hosting">Layanan Penambahan Kapasitas server virtual/hosting</option>
                                <option value="Layanan Pembuatan Subdomain">Layanan Pembuatan Subdomain</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Sistem / Aplikasi*</label>
                            <input type="text" name="aplikasi" required class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Tanggal Dibutuhkan*</label>
                            <input type="text" name="tanggal_dibutuhkan" id="datepicker1" required class="form-control">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Kebutuhan Permintaan*</label>
                            <textarea name="kebutuhan" id="" cols="30" rows="3"class="form-control" required></textarea>
                        </div>
                        <hr class="mt-2">
                        <p>INFORMASI DEVELOPER</p>
                        <hr>
                        <div class="col-md-6 mb-2">
                            <label for="">Nama*</label>
                            <input type="text" name="nama_developer" required class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Unit Kerja*</label>
                            <input type="text" name="unit_kerja" required class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Jabatan*</label>
                            <input type="text" name="jabatan" required class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Bahasa Pemrograman*</label>
                            <input type="text" name="pemrograman" required class="form-control">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Analisa Dampak*</label>
                            <select name="dampak" id="type" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Surat Permohonan / Nota Dinas / Dokumen Hasil VA*</label>
                            <input type="file" name="nota_dinas" class="file-upload form-control" required accept="application/pdf" max-size="2048">
                        </div>
                        <div id="server">
                            
                        </div>
                        <div id="domain">
                           
                        </div>
                        <div id="internal">
                            
                        </div>
                        <div id="pihak3">
                            
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
        $('#datepicker1').datepicker({
            format: 'yyyy/mm/dd',
            autoclose : true,
        })

        $('#server').hide();
        $('#domain').hide();
        
        $('#type').on('change', function(){
            var type = $(this).val();

            if(type == ''){
                $('#server').hide().find(':input').prop('readonly', true);
                $('#domain').hide().find(':input').prop('readonly', true);
            }
            else if(type == 'Layanan Pembuatan Server Virtual/Hosting'){
                $('#server').show().find(':input').prop('readonly', false);
                $('#domain').hide().find(':input').prop('readonly', true);
            }
            else{
                $('#server').hide().find(':input').prop('readonly', true);
                $('#domain').show().find(':input').prop('readonly', false);
            }
            
        });
    </script>
    @endsection
    </body>
</html>
