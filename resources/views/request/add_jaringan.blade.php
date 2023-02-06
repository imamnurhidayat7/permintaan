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
                    <form action="{{url('tambah-jaringan')}}" method="post" class="myForm" enctype="multipart/form-data">@csrf
                    <div class="row mt-4 py-4">
                        <div class="col-md-12 mb-2">
                            <label for="">Jenis Layanan*</label>
                            <select name="jenis" id="type" class="form-control" required>
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="Layanan Penanganan Gangguan Jaringan">Layanan Penanganan Gangguan Jaringan</option>
                                <option value="Layanan Dukungan Teknis Jaringan Nirkabel">Layanan Dukungan Teknis Jaringan Nirkabel</option>
                                <option value="Layanan Interkoneksi">Layanan Interkoneksi</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="">Pesan*</label>
                            <textarea name="pesan" id="" cols="30" rows="3"class="form-control" required></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                        <label for="">Surat Rekomendasi/ Nota Dinas*</label>
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
