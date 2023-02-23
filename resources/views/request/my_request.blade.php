@extends(Session::get('role').'.master_'.Session::get('role'))

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <a href="{{url()->previous()}}" class="btn btn-sm btn-default"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                        <h4 class="fw-medium mb-4 text-center">Data Request Saya</h4>
                        <a class="btn btnTambah btn-sm btn-primary mb-4"> <i class="fa fa-plus"></i> Tambah Request</a>
                        <div class="row">
                        <div class="col-md-4 mb-4 mt-4">
                            <label>Filter By Layanan</label>
                            <select class="form-control select2 filterlayanan" id="filter-layanan">
                                <option value="">Semua Layanan</option>
                                @foreach($layanan as $row)
                                <option value="{{$row->layanan}}">{{$row->layanan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 mt-4">
                            <label>Filter By Status</label>
                            <select class="form-control select2 filterstatus" id="filter-status" name="status">
                                <option value="">Semua</option>
                                <option value="Request Diajukan">Request Diajukan</option>
                                <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                                <option value="Sedang Diproses">Sedang Diproses</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditutup">Ditutup</option>
                            </select>
                        </div>
                        </div>

                        <table id="datatable3" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
            </form>
            <!-- end row -->

    <div class="modal fade bs-example-modal-xl" id="modalTambah" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-modal="true" role="dialog" >
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Tambah Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mini-stats-wid">
                    <div class="card-body" >
                        <div class="media mb-4 text-center">
                            <div class="media-body">
                                <h2 class="fw-large">Request Catalog</h2>
                                <h4 class="mb-0"></h4>
                            </div>
                        </div>
                        <div class="row mt-4 py-4">
                            @foreach($layanan as $row)
                            <div class="col-md-3 col-sm-12" @if($row->isLayananPusat == 1 && Session::get('isUserPusat') != 1) style="display:none;" @endif>
                                <div class="card card-layanan overflow-hidden py-3" style="background-color:#D6E4E5">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-12 text-center py-4">
                                            <img src="{{url('')}}/images/icon.png" alt="" width="50px">
                                                <h5 class="mb-4 mt-4">{{$row->layanan}}</h5>
                                                <a href="{{url('layanan', $row->id)}}" class="btn btn-sm btn-primary">Buat Request</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    
    </div> <!-- content -->
    @endsection
    @section('script')
    <script>
        
        $('.btnTambah').on('click', function(){
            $('#modalTambah').modal('show');
        });
 
    </script>
    <script type="text/javascript">
  $(function () {
    
    var table = $('#datatable3').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax: {
            url : "{{url('my-request')}}",
            method : 'GET',
            data : function (d) {
                d.status = $('#filter-status').val();
                d.kategori = 'pemohon';
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        },
        columns: [
            {data: 'no_req', name: 'no_req'},
            {data: 'created_at', name: 'created_at'},
            {data: 'layanan', name: 'layanan'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ]
    });

    $('#filter-layanan').on( 'change', function () {
        table
            .columns(2)
            .search( this.value )
            .draw();
    });

    $('#filter-status').on( 'change', function () {
        table
            .columns(3)
            .search( this.value )
            .draw();
    });

    $(document).on('click', '.btnReAssign', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#assign_id').val(id);
            $('#modalAssign').modal('show');
        });
    
  });
</script>
    @endsection
    </body>
</html>
