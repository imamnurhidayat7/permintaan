@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
            <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <h4 class="fw-medium mb-4">Form Tambah Layanan </h4>
                        <!-- <a class="btn btn-sm btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah"> <i class="fa fa-plus"></i> Tambah Layanan</a> -->
                        <form action="{{url('update-layanan')}}" method='post' class="outer-repeater">@csrf
                        <div class="row outer">
                        <div>
                            <div class="col-md-12">
                                <div class="row">
                                <div class="col-md-6 mb-3">
                                        <label for="basicpill-lastname-input">Nama Layanan</label>
                                        <input type="text" name="layanan" class="form-control" value="{{$layanan->layanan}}" required="">
                                </div>
                                <div class="col-md-6 mb-3">
                                        <label for="basicpill-lastname-input">Status</label>
                                        <select name="status" id="" class="form-control" required>
                                            <option disable selected>Pilih Status</option>
                                            
                                            <option value="1" @if($layanan->status == '1') selected @endif>Aktif</option>
                                            <option value="2" @if($layanan->status == '2') selected @endif>Tidak Aktif</option>
                                            
                                        </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                        <label for="basicpill-lastname-input">Bidang</label>
                                        <select name="id_bidang" id="" class="form-control" required>
                                            <option disable selected>Pilih Bidang</option>
                                            
                                            @foreach($bidang as $row)
                                            <option value="{{$row->id}}" @if($layanan->id_bidang == $row->id) selected @endif>{{$row->nama}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                        <label for="basicpill-lastname-input">Penanggung Jawab</label>
                                        <select name="id_pic" id="" class="form-control" required>
                                            <option value="">Pilih Penanggung Jawab</option>
                                            @foreach($pic as $row)
                                            <option value="{{$row->id}}" @if($layanan->id_pic == $row->id) selected @endif>{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                        <label for="basicpill-lastname-input">Pelaksana</label>
                                        <select name="id_pelaksana" id="" class="form-control" required>
                                            <option value="">Pilih Pelaksana</option>
                                            @foreach($pelaksana as $row)
                                            <option value="{{$row->id}}" @if($layanan->id_pelaksana == $row->id) selected @endif>{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="basicpill-lastname-input">Deskripsi Layanan</label>
                                    <textarea class="form-control" name="deskripsi" rows="100">{!! $layanan->deskripsi !!}</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$layanan->id}}">
                            <hr class="mt-4">
                            @if($layanan->page == '')
                            <h5>Form Input</h5>
                            <hr>
                            <div id="formDiv">
                            @foreach($layanan_fields as $row)
                                <div class="row mb-2" id="{{$row->id}}">
                                    <div class="col">
                                        <input type="text" value="{{$row->label}}" class="form-control" disabled>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btnEdit btn btn-md btn-success" data-id="{{$row->id}}" data-nama="{{$row->nama}}" data-label="{{$row->label}}" data-jenis="{{$row->jenis}}" data-tipe="{{$row->tipe}}" data-options="{{$row->options}}" data-required="{{$row->required}}">Edit</button>
                                        <button type="button" class="btnDelete btn btn-md btn-danger" data-id="{{$row->id}}">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <input type="button" class="btn btn-info mt-2 mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah"
                                    value="+" />
                            @endif
                        </div>
                        </div>
                        <button class="btn-lg btn btn-primary" type="submit">Submit</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->

            <div class="modal fade transaction-detailModal show" id="modalTambah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form id="formField">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="transaction-detailModalLabel">Tambah Field Input</h5>
                            <button type="button" class="tutup btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                    <label for="basicpill-lastname-input">Label</label>
                                    <input type="text" name="label" id="label" class="form-control" required="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="basicpill-lastname-input">Nama Field</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required="">
                                </div>
                                <div class="col-md-12 col-sm-12 mb-2">
                                    <label class="form-label">Jenis</label>
                                    <select name="jenis" id="jenis" class="jenis form-control" required>
                                        <option disable selected>Pilih Jenis</option>
                                        <option value="input">Input</option>
                                        <option value="select">Select</option>
                                        <option value="textarea">Textarea</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-sm-12 mb-2 div-tipe">
                                    <label class="form-label">Tipe Field</label>
                                    <select name="tipe" id="tipe" class="tipe form-control" required>
                                        <option disable selected>Pilih Tipe</option>
                                        <option value="text">Text</option>
                                        <option value="number">Number</option>
                                        <option value="file">File</option>
                                        <option value="textarea">Date</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-2 div-option">
                                    <label for="">Options (Tekan Enter untuk menyimpan)</label>
                                    <input type="text" id="options" data-role="tagsinput" name="options" class="options form-control">
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    <input type="checkbox" class="form-check-input" id="required">
                                    <label for="required" class="form-check-label">Wajib diisi</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="jenis_input" value="">
                            <input type="hidden" id="layanan_id" value="{{$layanan->id}}">
                            <input type="hidden" id="field_id">
                            <button type="button" class="btnAdd btn btn-primary">Submit</button>
                            <button type="button" class="tutup btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- end row -->

            <!-- Static Backdrop Modal -->
            <div class="modal fade" id="modalHapus" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">Hapus Field</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p style="font-size:16px; font-weight:200px">Apakah anda yakin ingin menghapus field ini?</p>
                        <div class="modal-footer">
                            <button type="button" class="hapus btn btn-primary" onclick>Hapus</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

    </div> <!-- content -->
    @endsection
    @section('script')
    <script src="{{asset('js/jquery-repeater.min.js')}}"></script>
    <script src="{{asset('js/form-repeater.int.js')}}"></script>
    <script>
        $('.div-tipe').hide();
        $('.div-option').hide();

        $('.jenis').change(function(){
            var jenis = $(this).val();

            if(jenis != ''){
                if(jenis === 'select'){
                    $('.div-tipe').fadeOut();
                    $('.div-option').show();
                }
                else if(jenis === 'input'){
                    $('.div-option').fadeOut();
                    $('.div-tipe').show();
                }
                else{
                    $('.div-option').fadeOut();
                    $('.div-tipe').fadeOut();
                }
            }
        });

        $('.btnAdd').on('click', function(e){
            e.preventDefault;
            var formData = new FormData(document.querySelector('#formField'));
            formData.append('layanan_id', $('#layanan_id').val());

            if($('#required').is(':checked')){
                formData.append('required', 1);
            }

            if($('#jenis_input').val() === 'update'){
                formData.append('id', $('#field_id').val());
            }

            formData.append('jenis_input', $('#jenis_input').val());

            // for (var pair of formData.entries()) {
            //  console.log(pair[0]+ ', ' + pair[1]); 
            //  }


            $.ajax({
                type:"POST",
                url:"{{url('tambah-field')}}/",
                data:formData,
                processData:false,
                contentType:false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(res){  
                    //console.log(res);

                    if($('#jenis_input').val() === 'update'){
                        // $.toast({
                        //     heading: 'Berhasil',
                        //     text: 'berhasil mengupdate field!',
                        //     showHideTransition: 'plain',
                        //     icon: 'success',
                        //     position: 'top-right',
                        //     stack:false,
                        // });
                        $('#'+$('#field_id').val()).html(res);
                    }
                    else{
                        // $.toast({
                        //     heading: 'Berhasil',
                        //     text: 'berhasil menambahkan field!',
                        //     showHideTransition: 'plain',
                        //     icon: 'success',
                        //     position: 'top-right',
                        //     stack:false,
                        // });
                        $('#formDiv').append(res);
                    }

                    $('#modalTambah').modal('hide');
                    $('#jenis_input').val('');
                    $('.jenis').val('').change();
                    $('#field_id').val('');
                    $('#formField').trigger('reset');

                },
                error:function(response){
                    console.log(response);
                }

            });
        });

        $('.tutup').on('click', function(){
            $('#jenis_input').val('');
            $('#field_id').val('');
            $('.jenis').val('').change();
            $('#formField').trigger('reset');
        });

        $(document).on('click', '.btnEdit', function(e){
            e.preventDefault;
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var label = $(this).data('label');
            var jenis = $(this).data('jenis');
            var tipe = $(this).data('tipe');
            var options = $(this).data('options');
            var required = $(this).data('required');

            if(jenis === 'select'){
                $('.div-tipe').fadeOut();
                $('.div-option').show();
            }
            else if(jenis === 'input'){
                $('.div-option').fadeOut();
                $('.div-tipe').show();
            }
            else{
                $('.div-option').fadeOut();
                $('.div-tipe').fadeOut();
            }

            if(required === 1){
                $('#required').prop('checked', true);
            }

            $('#field_id').val(id);
            $('#nama').val(nama);
            $('#label').val(label);
            $('#jenis').val(jenis);
            $('#tipe').val(tipe);
            //$('#options').val(options);
            //console.log($('#options').val());
            var strArray = options.split(",");
        
            // Display array values on page
            for(var i = 0; i < strArray.length; i++){
                $('#options').tagsinput('add', strArray[i]);
            }

            $('#jenis_input').val('update');

            $('#modalTambah').modal('show');


        });

        $(document).on('click', '.btnDelete', function(e){
            e.preventDefault;

            $('.hapus').attr('data-id', $(this).data('id'));
            $('#modalHapus').modal('show');
        });

        $('.hapus').on('click', function(){

            var id = $(this).data('id');
            //console.log(id);
            $.ajax({
                type:"GET",
                url:"{{url('hapus-field')}}/"+id,
                data:{id:id},
                processData:false,
                contentType:false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(res){  
                    console.log(res);
                        // $.toast({
                        //     heading: 'Berhasil',
                        //     text: 'berhasil menghapus field!',
                        //     showHideTransition: 'plain',
                        //     icon: 'success',
                        //     position: 'top-right',
                        //     stack:false,
                        // });

                        $('#'+id).remove();

                        $('#modalHapus').modal('hide');

                },
                error:function(response){
                    console.log(response);
                }

            });
        });

        var table = $('#datatable2').DataTable({
            "order": [[ 0, "desc" ]],
        });
    

    </script>
    <script type="text/javascript">
        CKEDITOR.replace('deskripsi', {
            filebrowserUploadUrl: "{{route('upload.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
        });
    </script>
    @endsection
    </body>
</html>