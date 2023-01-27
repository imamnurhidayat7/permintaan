@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <h4 class="fw-medium mb-4 text-center">Data Layanan Pusdatin ATR/BPN</h4>
                        <!-- <a class="btn btn-sm btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah"> <i class="fa fa-plus"></i> Tambah Layanan</a> -->
                            
                        <a class="btn btn-sm btn-primary mb-4" href="#" data-bs-toggle="modal" data-bs-target="#modalTambah"> <i class="fa fa-plus"></i> Tambah Layanan</a>
            
                        <table id="datatable2" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                            <th>Layanan</th>
                            <th>Bidang</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($layanan as $row)
                            <tr>
                                <td>{{$row->layanan}}</td>
                                <td>{{$row->bidang->nama}}</td>
                                <td>@if($row->status == '1') Aktif @else Tidak Aktif @endif</td>
                                <td>
                                <a href="{{url('admin/layanan/edit', $row->id)}}" class="btn btn-success waves-effect waves-light btnEdit" role="button"><i class="mdi mdi-pencil d-block font-size-16"></i> </a>
                                <!-- <a class="btn btn-danger waves-effect waves-light btnHapus" data-id="{{$row->id}}" role="button"><i class="mdi mdi-delete d-block font-size-16"></i> </a>
                                </td>      -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
            </form>
            <!-- end row -->
    
    <div class="modal fade transaction-detailModal show" id="modalTambah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="{{url('/admin/tambah-layanan')}}" method="post">@csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaction-detailModalLabel">Tambah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Nama Layanan</label>
                                <input type="text" name="layanan" class="form-control" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Bidang</label>
                                <select name="id_bidang" id="" class="bidang form-control" required>
                                    <option value="">Pilih Bidang</option>
                                    @foreach($bidang as $row)
                                    <option value="{{$row->id}}">{{$row->nama}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div> <!-- content -->
    @endsection
    @section('script')
    <script>
        var table = $('#datatable2').DataTable({
            "order": [[ 0, "desc" ]],
        });

    </script>
    @endsection
    </body>
</html>
