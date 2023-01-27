@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="fw-medium mb-4 text-center">Data Approver</h4>
                        <a href="#" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Approver</a>
                        
                        <!-- Static Backdrop Modal -->
                        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                            <form action="{{url('/admin/input-data-approver')}}" method="post">@csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Input Data Approver</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="nama" required/>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email"/>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                    <label>NIP</label>
                                                    <input type="number" class="form-control" name="nip"/>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>

                        <!-- Static Backdrop Modal -->
                        <div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                            <form action="{{url('/admin/update-data-approver')}}" method="post">@csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Update Data Approver</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="nama"  id="nama" required/>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"/>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                    <label>NIP</label>
                                                    <input type="number" class="form-control" id="nip" name="nip"/>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" id="edit_id">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>

                        <!-- Static Backdrop Modal -->
                        <div class="modal fade" id="modalHapus" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                            <form action="{{url('/admin/delete-data-approver')}}" method="post">@csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Hapus Data Approver</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin ingin menghapus approver ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" id="delete_id">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        
                        <table id="datatable2" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($approver as $row)
                            <tr>
                                <td>{{$row->nama}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->nip}}</td>
                                <td>
                                <a class="btn btn-success waves-effect waves-light btnEdit" data-id="{{$row->id}}" data-nama="{{$row->nama}}" data-email="{{$row->email}}" data-nip="{{$row->nip}}" role="button"><i class="mdi mdi-pencil d-block font-size-16"></i> </a>
                                <a class="btn btn-danger waves-effect waves-light btnHapus" data-id="{{$row->id}}" role="button"><i class="mdi mdi-delete d-block font-size-16"></i> </a>
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
    </div> <!-- content -->
    
    @endsection
    @section('script')
    <script>
        $('#datatable2').DataTable({
            "order": [[ 0, "asc" ]]
        });
        $(".btnEdit").on('click', function (){
            $('#edit_id').val($(this).data("id"));
            $('#nama').val($(this).data("nama"));
            $('#email').val($(this).data("email"));
            $('#nip').val($(this).data("nip"));
            $('#modalEdit').modal('show');
        });

        $(".btnHapus").on('click', function (){
            $('#delete_id').val($(this).data("id"));
            $('#modalHapus').modal('show');
        });
    </script>
    @endsection
    </body>
</html>
