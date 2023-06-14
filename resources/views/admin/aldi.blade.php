@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <a href="{{url()->previous()}}" class="btn btn-sm btn-default"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                        <h4 class="fw-medium mb-4 text-center">Data Pegawai Simpeg</h4>
                        <div class="row">
                        <h5>Cari Pegawai</h5>
                        <div class="col-md-4 col-sm-12 mb-4 mt-4">
                            <label>Tipe Pencarian</label>
                            <select class="form-control select2" name="tipe" id="tipe" required>
                                <option value="">Pilih Tipe</option>
                                <option value="nip">NIP</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-4 mt-4">
                            <label>Keyword</label>
                            <input type="text" class="form-control" name="keyword" id="keyword" required>
                        </div>
                        </div>
                        <button id="cariPegawai" class="btn btn-primary mb-4">Cari Pegawai</button>
                        <div class="test">
                        <table id="datatable3" class="table table-bordered nowrap w-100">
                        <thead>
                            <tr>
                            <th>Action</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        </table>
                        </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
            </form>
            <!-- end row -->

    <div class="modal fade bs-example-modal-md" id="modalEdit" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-modal="true" role="dialog" >
        <form action="{{url('update-email-simpeg')}}" method="post">@csrf
        <div class="modal-dialog modal-md" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Email Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                    <label for="">NIP</label>
                    <input type="text" class="form-control" name="nip" id="edit_nip" readonly>
                    </div>
                    <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" name="email" id="edit_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </form>
    </div>
    
    </div> <!-- content -->
    @endsection
    @section('script')
    <script type="text/javascript">
    $(function () {
        var table = $('#datatable3').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                "order": [[ 1, "desc" ]],
                ajax: {
                    url : "{{url('aldi')}}",
                    method : 'GET',
                    data : function (d) {
                        d.tipe = $('#tipe').val();
                        d.keyword = $('#keyword').val();
                    },
                    
                    error: function (request, status, error) {
                        console.log(request.responseText);
                    }
                },
                columns: [
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'NAMA', name: 'NAMA'},
                    {data: 'NIP', name: 'NIP'},
                    {data: 'EMAIL', name: 'EMAIL'},
                
                ]
            });
            $('#datatable3').parents('div.test').first().hide();

        $('#cariPegawai').on('click', function(e){
            var tipe = $('#tipe').val();
            var keyword = $('#keyword').val();

            if(tipe === ""){
                $.toast({
                    heading: 'Gagal',
                    text: 'Tipe pencarian harus dipilih',
                    showHideTransition: 'plain',
                    icon: 'error',
                    position: 'top-left',
                    stack:false,
                });
            }

            else if(keyword === ""){
                $.toast({
                    heading: 'Gagal',
                    text: 'Keyword harus diisi',
                    showHideTransition: 'plain',
                    icon: 'error',
                    position: 'top-left',
                    stack:false,
                });
            }

            else{
                $('#datatable3').parents('div.test').first().show();
                table.draw();
            }

           
        });

        $(document).on('click', '.btnReAssign', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#assign_id').val(id);
                $('#modalAssign').modal('show');
            });
        
    });
</script>
<script>
        $("body").on("click", "a.btnEdit", function (e) {
            e.preventDefault();
            $('#edit_email').val($(this).data('email'));
            $('#edit_nip').val($(this).data('nip'));
            $('#modalEdit').modal('show');
        });
 
    </script>
    @endsection
    </body>
</html>
