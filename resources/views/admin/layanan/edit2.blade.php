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
                        <div class="row outer" data-repeater-list="outer-group">
                        <div data-repeater-item class="outer">
                            <div class="col-md-12">
                                <div class="row">
                                <div class="col-md-4 mb-3">
                                        <label for="basicpill-lastname-input">Nama Layanan</label>
                                        <input type="text" name="layanan" class="form-control" value="{{$layanan->layanan}}" required="">
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
                                        <label for="basicpill-lastname-input">Status</label>
                                        <select name="status" id="" class="form-control" required>
                                            <option disable selected>Pilih Status</option>
                                            
                                            <option value="1" @if($layanan->status == '1') selected @endif>Aktif</option>
                                            <option value="2" @if($layanan->status == '2') selected @endif>Tidak Aktif</option>
                                            
                                        </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="basicpill-lastname-input">Deskripsi Layanan</label>
                                    <textarea class="ckeditor form-control" name="deskripsi" rows="100">{!! $layanan->deskripsi !!}</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$layanan->id}}">
                            <hr class="mt-4">
                            <h5>Form Input</h5>
                            <hr>
                            <div class="inner-repeater mb-4 mt-2">
                                <div data-repeater-list="inner-group" class="inner mb-3">
                                    @foreach($layanan_fields as $row)
                                    <div data-repeater-item class="inner mb-3 row">
                                    <div class="col-md-3 col-sm-12 mb-2">
                                        <label class="form-label">Label</label>
                                        <input type="text" name="label[]" class="form-control" value="{{$row->label}}" required>
                                    </div>
                                    <div class="col-md-3 col-sm-12 mb-2">
                                        <label class="form-label">Nama Field</label>
                                        <input type="text" name="nama[]" class="form-control" value="{{$row->nama}}" required>
                                    </div>
                                    <div class="col-md-3 col-sm-12 mb-2">
                                        <label class="form-label">Jenis</label>
                                        <select name="jenis[]" id="" class="form-control" required>
                                            <option disable selected>Pilih Jenis</option>
                                            <option value="input" @if($row->jenis == 'input') selected @endif>Input</option>
                                            <!-- <option value="select" @if($row->jenis == 'select') selected @endif>Select</option> -->
                                            <option value="textarea" @if($row->jenis == 'textarea') selected @endif>Textarea</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12 mb-2">
                                        <label class="form-label">Tipe Field</label>
                                        <select name="tipe[]" id="" class="form-control" required>
                                            <option disable selected>Pilih Tipe</option>
                                            <option value="text" @if($row->tipe == 'text') selected @endif>Text</option>
                                            <option value="number" @if($row->tipe == 'number') selected @endif>Number</option>
                                            <option value="file" @if($row->tipe == 'file') selected @endif>File</option>
                                            <option value="date" @if($row->tipe == 'date') selected @endif>Date</option>
                                        </select>
                                    </div>
                                    <div class="col-auto mb-2">
                                        <label class="form-label" style="color:white;">Hapus</label><br/>
                                        <input data-repeater-delete type="button" class="btn btn-danger"
                                                value="X" />
                                    </div>
                                    
                                    </div>
                                    @endforeach
                                </div>
                                <input data-repeater-create type="button" class="btn btn-success inner"
                                    value="+" />
                        </div>
                        </div>
                        </div>
                        <button class="btn-md btn btn-primary" type="submit">Submit</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
            <!-- end row -->
    </div> <!-- content -->
    @endsection
    @section('script')
    <script src="{{asset('js/jquery-repeater.min.js')}}"></script>
    <script src="{{asset('js/form-repeater.int.js')}}"></script>
    <script>
        var table = $('#datatable2').DataTable({
            "order": [[ 0, "desc" ]],
        });
        $('.ckeditor').ckeditor();
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