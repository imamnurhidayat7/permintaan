@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <h4 class="fw-medium mb-4 text-center">Data User</h4>
                        <a class="btn btn-sm btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah"> <i class="fa fa-plus"></i> Tambah User</a>
                        <table id="datatable2" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Role</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($user as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->pegawaiid}}</td>
                                <td>{{$row->role}}</td>
                                <td>
                                <a data-id="{{$row->id}}" data-id_bidang="{{$row->id_bidang}}" data-name="{{$row->name}}" data-role="{{$row->role}}" data-pegawaiid="{{$row->pegawaiid}}" class="btn btn-success waves-effect waves-light btnEdit" role="button"><i class="mdi mdi-pencil d-block font-size-16"></i> </a>
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
        <form action="{{url('admin/users/tambah')}}" method="post">@csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaction-detailModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Nama</label>
                                <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">NIP</label>
                                <input type="text" name="pegawaiid" class="form-control" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Role</label>
                                <select name="role" id="" class="ubahRole form-control" required>
                                    <option value="">Pilih Role</option>
                                    @if(Session::get('isSuperAdmin'))
                                    <option value="admin">Admin</option>
                                    @endif
                                    <option value="pelaksana">Pelaksana</option>
                                    <option value="kasi">Kepala Subbidang</option>
                                    <option value="kabid">Kepala Bidang</option>
                                    <!-- <option value="kapus">Kepala Pusdatin</option> -->
                                </select>
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Bidang</label>
                                <select name="id_bidang"  class="bidang form-control" required>
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

    <div class="modal fade transaction-detailModal show" id="modalEdit" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="{{url('admin/users/update')}}" method="post">@csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaction-detailModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Nama</label>
                                <input type="text" name="name" class="form-control" id="edit_name">
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">NIP</label>
                                <input type="text" name="pegawaiid" class="form-control" id="edit_pegawaiid" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Role</label>
                                <select name="role" class="ubahRole form-control" id="edit_role" required>
                                    <option value="">Pilih Role</option>
                                    @if(Session::get('isSuperAdmin'))
                                    <option value="admin">Admin</option>
                                    @endif
                                    <option value="pelaksana">Pelaksana</option>
                                    <option value="kasi">Kepala Subbidang</option>
                                    <option value="kabid">Kepala Bidang</option>
                                    <!-- <option value="kapus">Kepala Pusdatin</option> -->
                                </select>
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="basicpill-lastname-input">Bidang</label>
                                <select id="edit_id_bidang" name="id_bidang" class="bidang form-control"  required>
                                    <option value="">Pilih Bidang</option>
                                    @foreach($bidang as $row)
                                    <option value="{{$row->id}}">{{$row->nama}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit_id">
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
        
        $('.ubahRole').on('change', function(){
            var role = $(this).val();
            if(role != ''){
                if(role === 'customerservice'){
                    $('.bidang').prop('disabled','disabled');
                    $('.bidang').val('');
                }
                else{
                    $('.bidang').prop('disabled',false);
                }
            }
        });

        var table = $('#datatable2').DataTable({
            "order": [[ 0, "desc" ]],
        });

        $('.btnEdit').on('click', function(){
            //alert('a');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var pegawaiid = $(this).data('pegawaiid');
            var id_bidang = $(this).data('id_bidang');
            var role = $(this).data('role');

            $('#edit_name').val(name);
            $('#edit_pegawaiid').val(pegawaiid);
            $('#edit_role').val(role);
            $('#edit_id_bidang').val(id_bidang);
            $('#edit_id').val(id);

            $('#modalEdit').modal('show');
        });

    </script>
    @endsection
    </body>
</html>
