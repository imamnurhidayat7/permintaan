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
                    <form action="{{url('tambah-akses')}}" method='post' class="outer-repeater" enctype="multipart/fomr-data">@csrf
                        <div class="row outer" data-repeater-list="outer-group">
                        <div data-repeater-item class="outer">
                            <div class="row">
                                <input type="hidden" name="id" value="{{$layanan->id}}">
                                <div class="col-md-6 mb-2">
                                    <label for="">Jenis Layanan*</label>
                                    <select name="jenis" id="type" class="form-control" required>
                                        <option value="">Pilih Jenis Layanan</option>
                                        <option value="VPN">VPN</option>
                                        <option value="Akses Jaringan">Akses Jaringan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Kategori*</label>
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Internal">Internal</option>
                                        <option value="Pihak Ketiga">Pihak Ketiga</option>
                                    </select>
                                </div>
                            </div>
                            <div id="internal">
                                <div class="col-md-12 mb-2">
                                    <label for="">Peralatan yang digunakan*</label>
                                    <input type="text" name="peralatan" class="form-control" required>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="">Mac Address*</label>
                                    <input type="text" name="mac_address" class="form-control" required>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="">IP yang ingin diakses*</label>
                                    <textarea name="ip_address" id="" cols="30" rows="3" class="form-control">

                                    </textarea>
                                </div>
                            </div>
                            <div id="pihak3">
                            <hr>
                            <h5 class="text-center">DATA PEKERJAAN</h5>
                            <hr>
                            <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="">Nama Pekerjaan*</label>
                                <input type="text" name="nama_pekerjaan" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">Perusahaan / Vendor*</label>
                                <input type="text" name="perusahaan" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">Tanggal Mulai*</label>
                                <input autocomplete="off" type="text" id="datepicker1" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">Tanggal Selesai*</label>
                                <input autocomplete="off" type="text" id="datepicker2" name="tanggal_selesai" class="form-control" required>
                            </div>
                            </div>
                            <hr>
                            <h5 class="text-center">DATA PERSONEL</h5>
                            <hr>
                            <div class="inner-repeater mb-4 mt-2">
                                    <div data-repeater-list="inner-group" class="inner mb-3">
                                        <div data-repeater-item class="inner mb-3 row">
                                            <div class="col-md-3 col-sm-12 mb-2">
                                            <label class="form-label">Nama Personel*</label>
                                            <input type="text" name="nama[]" class="form-control" required>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-2">
                                                <label class="form-label">Peralatan yang digunakan*</label>
                                                <input type="text" name="peralatan[]" class="form-control" required>
                                            </div>
                                            <div class="col-md-2 col-sm-12 mb-2">
                                                <label class="form-label">Mac Address*</label>
                                                <input type="text" name="mac_address[]" class="form-control" required>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-2">
                                                <label class="form-label">IP Address yang dituju*</label>
                                                <input type="text" name="ip_address[]" class="form-control" required>
                                            </div>
                                            <div class="col-auto mb-2">
                                                <label class="form-label" style="color:white;">Hapus</label><br/>
                                                <input data-repeater-delete type="button" class="btn btn-danger"
                                                        value="X" />
                                            </div>
                                            
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-sm btn-success inner"
                                            value="+ Tambah Personel" />
                                            <hr>
                                </div>
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="submit btn btn-md btn-primary mt-4">Submit</button>
                    </form>
                </div>
            </div>
        </div> 
    </div>
   
    @endsection 
    @section('script')
    <script src="{{asset('js/jquery-repeater.min.js')}}"></script>
    <script src="{{asset('js/form-repeater.int.js')}}"></script>
    <script>
        $('#internal').hide();
        $('#pihak3').hide();

        // set default dates
        var start = new Date();
        // set end date to max one year period:
        var end = new Date(new Date().setYear(start.getFullYear()+1));


        $('#datepicker1').datepicker({
            format: 'yyyy/mm/dd',
            startDate : start,
            endDate   : end,
            autoclose : true,
        }).on('changeDate', function(){
            // set the "toDate" start to not be later than "fromDate" ends:
            $('#datepicker2').datepicker('setStartDate', new Date($(this).val()));
        });

        $('#datepicker2').datepicker({
            format: 'yyyy/mm/dd',
            startDate : start,
            endDate   : end,
            autoclose : true,
        // update "fromDate" defaults whenever "toDate" changes
        }).on('changeDate', function(){
            // set the "fromDate" end to not be later than "toDate" starts:
            $('#datepicker1').datepicker('setEndDate', new Date($(this).val()));
        });
        
        $('#kategori').on('change', function(){
            //alert('a');
            var type = $(this).val();

            if(type == ''){
                $('#internal').hide().find(':input').prop('readonly', true);
                $('#pihak3').hide().find(':input').prop('readonly', true);
            }
            else if(type == 'Internal'){
                $('#internal').show().find(':input').prop('readonly', false);
                $('#pihak3').hide().find(':input').prop('readonly', true);
            }
            else{
                $('#internal').hide().find(':input').prop('readonly', true);
                $('#pihak3').show().find(':input').prop('readonly', false);
            }
            
        });
    </script>
    @endsection
    </body>
</html>
