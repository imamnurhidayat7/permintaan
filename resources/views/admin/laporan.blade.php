@extends(Session::get('role').'.master_'.Session::get('role'))

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">Semua Permintaan</p>
                                <h4 class="mb-0">{{count($request)}}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">Email</p>
                                <h4 class="mb-0">{{$email}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">Hak Akses</p>
                                <h4 class="mb-0">{{$akses}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">Server</p>
                                <h4 class="mb-0">{{$server}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted fw-medium">VA</p>
                                <h4 class="mb-0">{{$va}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        <!-- end row -->
    </div>
</div>
<div>
<div class="card py-4">
    <div class="card-body">
    <a href="{{url()->previous()}}" class="btn btn-sm btn-default"><i class="mdi mdi-arrow-left"></i> Kembali</a>
    <h4 class="fw-medium mb-4 text-center">Laporan Permintaan Berdasarkan Unit Kerja</h4>
    

    <table id="datatable3" class="table table-bordered w-100">
    <thead>
        <tr>
        <th>Kantor</th>
        <th>Jumlah Request</th>
        <th>Hak Akses</th>
        <th>Email</th>
        <th>Server</th>
        <th>VA</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    </table>
    </div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
        
            
    var table = $('#datatable3').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax: {
            url : "{{url('laporan')}}",
            method : 'GET',
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        },
        columns: [
            {data: 'kantor', name: 'kantor'},
            {data: 'total_req', name: 'total_req'},
            {data: 'akses', name: 'akses'},
            {data: 'email', name: 'email'},
            {data: 'server', name: 'server'},
            {data: 'va', name: 'va'},
        
        ],
        "order": [[ 1, "desc" ]],

    });
        
    
</script>
@endsection