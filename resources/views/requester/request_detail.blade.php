@extends('layouts.master')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body">
                        <a href="{{url()->previous()}}" class="btn btn-sm btn-default"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                        <div class="text-center">
                        <h4 class="fw-medium mb-2">Request #{{$request->no_req}}</h4>
                        <p>Tanggal dibuat : {{$request->created_at}}</p>
                        <button style="pointer-events: none;" type="button" class="btn @if($request->status=='Menunggu Persetujuan') btn-warning @elseif($request->status=='Ditolak') btn-danger @else btn-success @endif btn-sm btn-rounded waves-effect waves-light">{{$request->status}}</button><br/>
                        <a class="btn btn-info btn-sm waves-effect mt-4 mr-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalRiwayat" >Lihat Perjalanan Request</a>
                        </div>
                    </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                    <form action="{{url('update-request')}}" class="myForm" method="post" enctype="multipart/form-data">@csrf
                        <!-- Nav tabs -->
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Requester</label>
                                            <input type="text" disabled name="name" value="{{$request->user->name}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Layanan</label>
                                            <input type="text" disabled  name="email" value="{{$request->layanan->layanan}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    @if($request->layanan->id == 27)
                                    @foreach($request->meta as $row)
                                        @if($row->nama != 'nip' && $row->value != '')
                                        @php $row->nama = str_replace('_'," ",$row->nama); @endphp
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="basicpill-lastname-input">{{$row->nama}}</label><br/>
                                                @if($row->type=='file')
                                                    @if($row->value)
                                                    <button class="btn btn-light btn-pdf" data-file="{{url('')}}/uploads/{{$row->value}}"  data-title="{{$row->nama}}" type="button">Lihat File</button>
                                                    @else
                                                    <button class="btn btn-light " disabled>Tidak ada File</button>
                                                    @endif

                                                    @if($request->status == 'Ditolak')
                                                        <input type="file"  name="{{$row->id}}" @if($row->value) value="{{$row->value}}" @endif class="form-control mt-3" accept="application/pdf" max-size="2048">
                                                    @endif  
                                                @else
                                                <input type="text" @if($request->status != 'Ditolak') readonly @endif name="{{$row->id}}" value="{{$row->value}}" class="form-control" required="">
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        
                                        @include('request.form_email')

                                        @if($request->keterangan != '')
                                        <div class="col-lg-12">
                                            <div class="mt-4">
                                                <div>
                                                <label for="basicpill-lastname-input">Keterangan :</label><br/>
                                                <span>{!!$request->keterangan!!}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @elseif($request->layanan->id == 26)
                                    <div class="col-lg-12">
                                        @if($request->status == 'Ditolak')
                                            @include('request.form_server_edit')
                                        @else
                                            @include('request.form_server')
                                        @endif
                                    </div>
                                    @elseif($request->layanan->id == 29)
                                    <div class="col-lg-12">
                                        @include('request.form_va')
                                    </div>
                                    @elseif($request->layanan->id == 25)
                                    <div class="col-lg-12">
                                        @if($request->status == 'Ditolak')
                                            @include('request.form_akses_edit')
                                        @else
                                            @include('request.form_akses')
                                        @endif
                                    </div>
                                    @else
                                    @foreach($request->layanan->fields as $row)
                                    @if($row->status_hapus != 1)
                                    <div class="col-12 mb-2">
                    
                                        @if($row->jenis == 'input')
                                            <label for="basicpill-lastname-input">{{$row->label}}</label><br/>
                                            @if($row->tipe=='file')
                                            @if($row->meta)
                                            <button class="btn btn-light btn-pdf" data-file="{{url('')}}/uploads/{{$row->meta->value}}"  data-title="{{$row->label}}" type="button">Lihat File</button>
                                            @else
                                            <button class="btn btn-light " disabled>Tidak ada File</button>
                                            @endif    
                                                @if($request->status == 'Ditolak')
                                                <input type="{{$row->tipe}}"  name="{{$row->nama}}" @if($row->meta) value="{{$row->meta->value}}" @endif class="form-control mt-3" accept="application/pdf" max-size="2048">
                                                @endif
                                            @else
                                            <input type="{{$row->tipe}}"  name="{{$row->nama}}" @if($row->meta) value="{{$row->meta->value}}" @endif class="form-control" required="">
                                            @endif
                                        @elseif($row->jenis == 'textarea')
                                            <label for="basicpill-lastname-input">{{$row->label}}</label>
                                            <textarea  name="{{$row->nama}}" class="form-control" id="" cols="30" rows="5">@if($row->meta) {{$row->meta->value}} @endif</textarea>
                                        @endif
                                            
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="request_id" value="{{$request->id}}">
                            <input type="hidden" name="layanan_id" value="{{$request->layanan->id}}">
                            <input type="hidden" name="status" value="Request Diajukan">
                            @if($request->status == 'Ditolak')
                            <button class="submit btn btn-primary mt-2" type="submit">Ajukan Kembali</button>
                            @endif
                            @if($request->status == 'Selesai')
                            <a class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#modalTutup" href="#">Selesaikan Request</a>
                            <a class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalBukaKembali" href="#">Buka Kembali</a>
                            @endif
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div>
                            <div class="chat-conversation p-3">
                                <ul class="list-unstyled mb-0" data-simplebar="init" style="max-height: 400px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: scroll;"><div class="simplebar-content" style="padding: 0px; ">
                                    <li> 
                                        <div class="chat-day-title">
                                            <span class="title">Riwayat Pesan</span>
                                        </div>
                                    </li>
                                    @if($catatan->isEmpty())
                                    <div class="text-center" style="position:relative; height:200px;">
                                        <h5 style="  margin: 0;position: absolute;top: 50%;left: 50%; transform: translate(-50%, -50%);">
                                            Belum ada riwayat pesan
                                        </h5>
                                    </div>
                                    @else
                                    @foreach($catatan as $row)
                                    <li @if($row->pengirim->id == Session::get('id')) class="right" @endif>
                                        <div class="conversation-list">
                                            <div class="ctext-wrap">
                                                <div class="conversation-name">{{$row->pengirim->name}}</div>
                                                <p>
                                                    {{$row->pesan}}
                                                </p>
                                                @if($row->attachment != '')
                                                <a class="btn-pdf" href="#" data-file="{{url('')}}/uploads/{{$row->attachment}}"  data-title="Attachment">Lihat Attachment</a>
                                                @endif

                                                <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i>{{$row->created_at}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach   
                                    @endif 
                                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 645px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>
                            </div>
                            @if($request->status != 'Ditutup' && $request->status != 'Selesai')
                            <div class="p-3 chat-input-section">
                                <form action="{{url('tambah-catatan')}}" class="myForm" method="post" enctype="multipart/form-data">@csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="row mb-2">
                                            <div class="position-relative">
                                                <textarea name="pesan" class="form-control" id="" cols="50" rows="3" required></textarea>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="position-relative">
                                                <input class="file-upload form-control" type="file" name="attachment" id="formFile" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                                                <!-- <label for="">*pdf/jpg/png</label> -->
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <input type="hidden" name="id_request" value="{{$request->id}}">
                                        <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                                            <button type="submit" class="submit btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Kirim</span> <i class="mdi mdi-send"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @elseif($request->status == 'Ditutup')
                            <div class="p-3 chat-input-section">
                                <p class="text-center">Request ditutup pada {{$request->updated_at}}</p>
                            </div>
                            @else
                            <div class="p-3 chat-input-section">
                                <p class="text-center">Request Selesai</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
            <!-- end row -->
            
    
            <div class="offcanvas offcanvas-end"  tabindex="-1" id="offcanvasScrolling" aria-modal="true" aria-labelledby="offcanvasScrollingLabel" role="dialog">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasScrollingLabel"></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <iframe id="link" src="" style="width:100%; height:100vh;" frameborder="0"></iframe>
                </div>
            </div>

             <!-- Static Backdrop Modal -->
             <div class="modal fade" id="modalBukaKembali" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action="{{url('buka-request')}}" method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">Buka Request #{{$request->no_req}}</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label>Keterangan</label>
                                <textarea name="pesan" id="" cols="30" rows="10" class="form-control" required>{{$request->keterangan}}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Attachment</label>
                                <input type="file" name="attachment" class="file-upload form-control" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                            <button type="submit" class="btn btn-primary">Buka Kembali</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>


            <!-- Modal Disposisi -->
            <div class="modal fade" id="modalRiwayat" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{url('/cs/request/ubah-status')}}"  method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Riwayat Perjalanan Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- <h4 class="card-title mb-4">Activity Feed</h4> -->
                                            <div data-simplebar="init" style="max-height: 376px; min-width:400px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                                <ul class="verti-timeline list-unstyled">
                                                @foreach($riwayat as $row)
                                                    <li class="event-list">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle font-size-18"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    {{$row->tahapan}}
                                                                    <p class="mb-0 text-muted">{{$row->created_at}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                </ul>
                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 640px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 228px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <!-- Static Backdrop Modal -->
            <div class="modal fade" id="modalTutup" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action="{{url('tutup-request')}}" method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">Request #{{$request->no_req}}</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p style="font-size:16px; font-weight:200px">Apakah anda yakin ingin menutup request ini?</p>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <input type="hidden" name="status" value="Ditutup">
                            <input type="hidden" name="tahapan" value="Ditutup oleh Pemohon">
                            <button type="submit" class="btn btn-primary">Tutup</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
                
    @endsection
    @section('script')
    <script>
        $(document).ready(function(){

        });
        var table = $('#datatable2').DataTable({
            "order": [[ 0, "desc" ]],
        });

        $('.btn-pdf').on('click', function(){
            var src = $(this).data('file');
            var title = $(this).data('title');
            $('#offcanvasScrollingLabel').text(title);
            $('#link').attr('src', src);
            $('#offcanvasScrolling').offcanvas('show');
        });

    </script>
    @endsection
    </body>
</html>
