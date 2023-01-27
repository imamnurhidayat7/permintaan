@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <h4 class="fw-medium mb-4 text-center">Data Request Layanan</h4>
                        
                        <div class="row">
                        <div class="col-md-4 mb-4 mt-4">
                            <label>Filter By Layanan</label>
                            <select class="form-control select2 filterlayanan" name="kantor_id">
                                <option value="">Semua Layanan</option>
                                @foreach($layanan as $row)
                                <option value="{{$row->layanan}}">{{$row->layanan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 mt-4">
                            <label>Filter By Status</label>
                            <select class="form-control select2 filterstatus" name="status">
                                <option value="">Semua</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Sudah Direspon">Sudah Direspon</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditutup">Ditutup</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 mt-4">
                            <label class="text-white">Filter By Status</label><br/>
                            <button class="btn btn-primary btn-filter" id="btn-filter">Filter</button>
                        </div>
                        </div>

                        <table id="datatable2" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                            <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Requester</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($request as $row)
                            <tr>
                                <td>{{$row->created_at}}</td>
                                <td>{{$row->layanan->layanan}}</td>
                                <td>{{$row->user->name}}</td>
                                <td>{{$row->status}}</td>
                                <td>
                                <a href="{{url('admin/request/detail', $row->id)}}" class="btn btn-light waves-effect waves-light" role="button"><i class="fa fa-eye"></i> </a>
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
        <form action="{{url('tambah-layanan')}}" method="post">@csrf
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

        $('.btn-filter').on('click', function(){
            table.draw();
        });

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var layanan = $('.filterlayanan').val();
                var status = $('.filterstatus').val();
                if (
                    (layanan == data[1] && status == data[3]) || 
                    (layanan == data[1] && status == "") || 
                    (layanan == "" && status == data[3]) || 
                    (layanan == "" && status == "")
                ) {
                    return true;
                }
                return false;
            }
        );

    </script>
    @endsection
    </body>
</html>
