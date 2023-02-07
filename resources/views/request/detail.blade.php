@extends(Session::get('role').'.master_'.Session::get('role'))

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body text-center">
                        <h4 class="fw-medium mb-2">Request #{{$request->no_req}}</h4>
                        <p>Tanggal dibuat : {{$request->created_at}}</p>
                        <button  type="" class="btn @if($request->status=='Request Diajukan') btn-warning @elseif($request->status=='Ditolak') btn-danger @else btn-success @endif btn-sm btn-rounded waves-effect waves-light" style="pointer-events: none;">{{$request->status}}</button>
                        <button type="" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" style="pointer-events: none;">{{$request->tahapan}}</button><br/>
                        
                       
                        <!-- <a class="btn btn-success btn-sm waves-effect mt-2 mr-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalEdit" data-tooltip="tooltip" title="Pesan"><i class="mdi mdi-wechat d-block font-size-16"></i></a> --> 
                        @if($request->id_user_disposisi == Session::get('id'))
                        <a class="btn btn-info btn-sm waves-effect mt-2 mr-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalUbahStatus" data-tooltip="tooltip" title="Pesan"><i class="mdi mdi-wechat d-block font-size-16"></i></a>    
                        @endif
                        <!-- <a class="btn btn-primary btn-sm waves-effect mt-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalEskalasi"><i class="mdi mdi-pencil d-block font-size-16"></i> </a> -->
                        </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-md-8">
                <div class="card" style="min-height:400px;">
                    <div class="card-body">
                        <!-- Nav tabs -->


                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Pemohon</label>
                                            <input type="text" readonly name="name" value="{{$request->user->name}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Kantor</label>
                                            <input type="text" readonly name="name" value="{{$request->user->kantor}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Layanan</label>
                                            <input type="text" readonly name="email" value="{{$request->layanan->layanan}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    @if($request->layanan->id == 27)
                                        @include('request.form_email')
                                    @elseif($request->layanan->id == 25)
                                    <div class="col-lg-12">
                                            @include('request.form_akses')
                                    </div>
                                    @elseif($request->layanan->id == 26)
                                    <div class="col-lg-12">
                                            @include('request.form_server')
                                    </div>
                                    @elseif($request->layanan->id == 29)
                                    <div class="col-lg-12">
                                            @include('request.form_va')
                                    </div>
                                    @elseif($request->layanan->id == 20)
                                    <div class="col-lg-12">
                                            @include('request.form_jaringan')
                                    </div>
                                    @elseif($request->layanan->id == 28)
                                    <div class="col-lg-12">
                                            @include('request.form_keamanan')
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
                                            @else
                                            <input type="{{$row->tipe}}" readonly name="{{$row->nama}}" @if($row->meta) value="{{$row->meta->value}}" @endif class="form-control" required="">
                                            @endif
                                        @elseif($row->jenis == 'textarea')
                                            <label for="basicpill-lastname-input">{{$row->label}}</label>
                                            <textarea  name="{{$row->nama}}" readonly class="form-control" id="" cols="30" rows="5">@if($row->meta) {{$row->meta->value}} @endif</textarea>
                                        @endif
                                            
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
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
                                </div>
                            </div>
                            @if($request->status == 'Menunggu Persetujuan' && Session::get('id') == $request->layanan->id_pic)
                            <div class="text-center">
                                <a class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#modalSetuju" href="#">Setujui Permintaan</a>
                                <a class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#modalTolak" href="#">Tolak Permintaan</a>
                            </div>
                            @endif

                            @if($request->status == 'Request Diajukan' && Session::get('id') == $request->layanan->id_pelaksana && $request->id_user_disposisi == Session::get('id'))
                            <div class="text-center">
                                <a class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#modalSetuju" href="#">Berkas Lengkap</a>
                                <a class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#modalTolak" href="#">Berkas Tidak Lengkap</a>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
                </div>
                @if($request->id_user_disposisi == Session::get('id') || $request->layanan->pic->id == Session::get('id') || $request->layanan->pelaksana->id == Session::get('id'))
                
                <div class="col-md-4">
                    <div class="card">
                        <div>
                            <div class="chat-conversation p-3">
                                <ul class="list-unstyled mb-0" data-simplebar="init" style="max-height: 300px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: scroll;"><div class="simplebar-content" style="padding: 0px; ">
                                    <li> 
                                        <div class="chat-day-title">
                                            <span class="title">Riwayat Penugasan</span>
                                        </div>
                                    </li>
                                    @if($disposisi->isEmpty())
                                    <div class="text-center" style="position:relative; height:200px;">
                                        <h5 style="  margin: 0;position: absolute;top: 50%;left: 50%; transform: translate(-50%, -50%);">
                                            Belum ada riwayat penugasan
                                        </h5>
                                    </div>
                                    @else
                                    @php $count = 0; @endphp
                                    @foreach($disposisi as $row)
                                    
                                    @if($row->pengirim->id == Session::get('id') || $row->penerima->id == Session::get('id') || $request->layanan->pic->id == Session::get('id'))
                                    @php $count++; @endphp
                                    <li @if($row->pengirim->id == Session::get('id')) class="right" @endif>
                                        <div class="conversation-list">
                                            <div class="ctext-wrap">
                                                <div class="conversation-name">Dari : {{$row->pengirim->name}}</div>
                                                <div class="conversation-name">Ke : {{$row->penerima->name}}</div>
                                                <p style="white-space: pre-line;">
                                                    <span>{{$row->pesan}}</span> 
                                                </p>
                                                @if($row->attachment != '')
                                                @php $ext = explode('.',$row->attachment) @endphp
                                                <a class="btn-att" href="#" data-ext="{{$ext[1]}}" data-file="{{url('')}}/uploads/{{$row->attachment}}" data-filename="{{$row->attachment}}"  data-title="Attachment">Lihat Attachment</a>
                                                @endif
                                                <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i>{{$row->created_at}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    
                                    @endforeach

                                    @if($count == 0)
                                    <div class="text-center" style="position:relative; height:200px;">
                                        <h5 style="  margin: 0;position: absolute;top: 50%;left: 50%; transform: translate(-50%, -50%);">
                                            Belum ada riwayat penugasan
                                        </h5>
                                    </div>
                                    @endif

                                    @endif
                                    
                                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 645px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>
                            </div>
                            <div class="p-3 chat-input-section">
                                @if($request->status == 'Sedang Diproses' || $request->status == 'Ditunda' || $request->status == 'Request Diajukan')
                                @if(Session::get('id') == $request->id_user_disposisi && Session::get('role') != 'kasi')
                                <form action="{{url('tambah-disposisi')}}" class="myForm" method="post" enctype="multipart/form-data">@csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="position-relative mb-2">
                                                <label>Tujuan</label>
                                                <select name="id_user_disposisi" id="" class="form-control" required>
                                                    @if($request->layanan->pelaksana->id == Session::get('id'))
                                                        <option value="">Pilih Tujuan</option>
                                                        @foreach($user as $row)
                                                        <option value="{{$row->id}}">{{$row->name}} - {{$row->jabatan}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="{{$request->layanan->pelaksana->id}}">{{$request->layanan->pelaksana->name}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="position-relative mb-4">
                                                <label for="">Pesan</label>
                                                <textarea name="pesan" class="form-control" id="" cols="50" rows="3" required></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label>Attachment</label>
                                                <input type="file" name="attachment" class="file-upload form-control" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                                            </div>
                                            <div class="position-relative">
                                            <input type="hidden" name="id_request" value="{{$request->id}}">
                                            <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                                            <button type="submit" class="submit btn btn-primary chat-send w-md waves-effect waves-light" style=""><span class="d-none d-sm-inline-block me-2">Kirim</span> <i class="mdi mdi-send"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                                @else
                                <div class="p-3 chat-input-section">
                                    <p class="text-center">Request {{$request->status}} pada {{$request->updated_at}}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($request->id_user_disposisi != Session::get('id'))
                <div class="col-md-4">
                    <div class="card">
                    <div>
                            <div class="chat-conversation p-3">
                                <ul class="list-unstyled mb-0" data-simplebar="init" style="max-height: 300px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: scroll;"><div class="simplebar-content" style="padding: 0px; ">
                                    <li> 
                                        <div class="chat-day-title">
                                            <span class="title">Riwayat Penugasan</span>
                                        </div>
                                    </li>
                                    
                                    <div class="text-center" style="position:relative; height:200px;">
                                        <h5 style="  margin: 0;position: absolute;top: 50%;left: 50%; transform: translate(-50%, -50%);">
                                            @if($request->layanan->id_pelaksana != Session::get('id'))
                                                Request ini tidak ditugaskan kepada anda
                                            @else
                                                Belum ada riwayat penugasan
                                            @endif
                                        </h5>
                                    </div>
                                    
                                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 645px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>
                            </div>
                            <div class="p-3 chat-input-section">
                                @if($request->status != 'Selesai' && $request->status != 'Ditutup' && $request->status != 'Ditolak')
                                
                                @else
                                <div class="p-3 chat-input-section">
                                    <p class="text-center">Request {{$request->status}} pada {{$request->updated_at}}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @endif
            </div> <!-- end row -->
            </form>
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

            <!-- Modal Disposisi -->
            <div class="modal fade" id="modalUbahStatus" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{url('/request/ubah-status')}}"  method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Pesan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="chat-conversation p-3" style="background-color:#fafafa">
                                        <ul class="list-unstyled mb-0" data-simplebar="init" style="max-height: 400px; min-width:400px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                            <li class="text-center"> 
                                                <!-- <div class="chat-day-title" style="background-color:#fafafa"> -->
                                                    <span class="title">Riwayat Pesan</span>
                                                <!-- </div> -->
                                            </li>
                                            <hr>
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
                                                        <p style="white-space: pre-line; margin-top: -1em;">
                                                           <span>{{$row->pesan}}</span> 
                                                        </p>
                                                       
                                                        @if($row->attachment != '')
                                                        @php $ext = explode('.',$row->attachment) @endphp
                                                        <a class="btn-att" href="#" data-ext="{{$ext[1]}}" data-file="{{url('')}}/uploads/{{$row->attachment}}"  data-title="Attachment">Lihat Attachment</a>
                                                        @endif

                                                        <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i>{{$row->created_at}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                            @endif
                                                
                                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 645px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>
                                    </div>
                                </div>
                                <hr>
                                @if(Session::get('id') == $request->id_user_disposisi)
                                @if($request->status == 'Sedang Diproses' || $request->status == 'Ditunda' || $request->status == 'Request Diajukan')
                                <div class="col-md-12 mb-3">
                                        <label>Status</label>
                                        <select name="status" id="" class="form-control" required>
                                            <option value="">Pilih Status</option>
                                            @if($request->status == 'Request Diajukan') 
                                            <option value="Request Diajukan" @if($request->status == 'Request Diajukan') selected @endif>Request Diajukan</option>  
                                            <option value="Ditunda" @if($request->status == 'Ditunda') selected @endif>Ditunda</option>
                                            <option value="Ditolak" @if($request->status == 'Ditolak') selected @endif>Ditolak</option>
                                            @else
                                            <option value="Sedang Diproses" @if($request->status == 'Sedang Diproses') selected @endif>Sedang Diproses</option>  
                                            <option value="Ditunda" @if($request->status == 'Ditunda') selected @endif>Ditunda</option>
                                            <option value="Selesai" @if($request->status == 'Selesai') selected @endif>Selesai</option>
                                            @if($request->layanan->id == 27)
                                            <option value="Ditolak" @if($request->status == 'Ditolak') selected @endif>Ditolak</option>
                                            @endif
                                            @endif
                                        </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Pesan</label>
                                    <textarea name="pesan" id="" cols="30" rows="4" class="form-control" required></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Attachment</label>
                                    <input type="file" name="attachment" class="file-upload form-control" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            @if($request->id_user_disposisi == Session::get('id') && $request->status != 'Selesai' && $request->status != 'Ditutup' && $request->status != 'Ditolak')
                            <button type="submit" class="btn btn-primary">Kirim</button>
                            @endif
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <div class="modal fade bs-example-modal-xl" id="modalAtt" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-modal="true" role="dialog" >
                <div class="modal-dialog modal-xl" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="margin-right:10px;" id="myExtraLargeModalLabel">Attachment</h5>
                            @if($request->layanan->pelaksana->id == Session::get('id'))
                            <button class="btn btnForward btn-sm btn-primary">Forward</button>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        
                            <iframe id="iframe" src="" width="100%" height="800px"></iframe>
                        
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <!-- Modal Setuju -->
            <div class="modal fade" id="modalSetuju" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action="{{url('setujui-request')}}" method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">Setujui Permintaan #{{$request->no_req}}</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($request->layanan->pelaksana->id == Session::get('id'))
                            <div class="col-md-12 mb-3">
                            <div class="position-relative mb-2">
                                <label>Permintaan Persetujuan</label>
                                <select name="id_user_disposisi" id="" class="form-control" required readonly>
                                    <option value="{{$request->layanan->pic->id}}">{{$request->layanan->pic->name}}</option>
                                </select>
                            </div>
                            </div>
                            @elseif($request->layanan->pic->id == Session::get('id'))
                            <input type="hidden" name="id_user_disposisi" value="{{$request->layanan->pelaksana->id}}">
                            @endif
                            <div class="col-md-12 mb-3">
                                <label>Keterangan</label>
                                <textarea name="pesan" id="" cols="100" rows="5" class="form-control" required></textarea>
                            </div>
                            <!-- <div class="col-md-12 mb-3">
                                <label>Attachment</label>
                                <input type="file" name="attachment" class="form-control" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                            @if($request->status == 'Menunggu Persetujuan')
                            <input type="hidden" name="status" value="Sedang Diproses">
                            <input type="hidden" name="tahapan" value="Ditugaskan ke Pelaksana">
                            <input type="hidden" name="jenis" value="2">
                            @elseif($request->status == 'Request Diajukan')
                            <input type="hidden" name="status" value="Menunggu Persetujuan">
                            <input type="hidden" name="tahapan" value="Menunggu Approval">
                            <input type="hidden" name="jenis" value="1">
                            @endif
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div class="modal fade" id="modalTolak" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action="{{url('tolak-request')}}" method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">Tolak Request #{{$request->no_req}}</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label>Keterangan</label>
                                <textarea name="pesan" id="" cols="100" rows="5" class="form-control" required>{{$request->keterangan}}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="old_status" value="{{$request->status}}">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <input type="hidden" name="status" value="Ditolak">
                            <input type="hidden" name="tahapan" value="Request Ditolak">
                            <button type="submit" class="btn btn-primary">Tolak</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Modal Forward -->
            <div class="modal fade" id="modalForward" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action="{{url('/request/ubah-status')}}" method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">Forward Berkas Ke Pemohon</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label>Status</label>
                                <select name="status" id="" class="form-control" required>
                                    <option value="">Pilih Status</option>
                                    @if($request->status == 'Request Diajukan') 
                                    <option value="Request Diajukan" @if($request->status == 'Request Diajukan') selected @endif>Request Diajukan</option>  
                                    <!-- <option value="Ditunda" @if($request->status == 'Ditunda') selected @endif>Ditunda</option> -->
                                    <option value="Ditolak" @if($request->status == 'Ditolak') selected @endif>Ditolak</option>
                                    @else
                                    <option value="Sedang Diproses" @if($request->status == 'Sedang Diproses') selected @endif>Sedang Diproses</option>  
                                    <option value="Ditunda" @if($request->status == 'Ditunda') selected @endif>Ditunda</option>
                                    <option value="Selesai" @if($request->status == 'Selesai') selected @endif>Selesai</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Pesan</label>
                                <textarea name="pesan" id="" cols="100" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                            <input type="hidden" name="attachment" id="edit_attachment">
                            <button type="submit" class="submit btn btn-primary">Kirim</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tambah Email -->
            <div class="modal fade" id="modalTambahEmail" data-bs-backdrop="static" data-bs-keyboard="false"
                                        tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="min-width:500px">
                    <form action="{{url('tambah-user-email')}}" method="post" enctype="multipart/form-data">@csrf
                    <div class="modal-content" style="min-width:400px;">
                        <div class="modal-header">
                            <h5 class="font-size-15">Tambah Email</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="id_email">
                            <input type="hidden" name="nip" id="edit_nip">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <button type="submit" class="submit btn btn-primary">Tambah</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>

                
    @endsection
    @section('script')
    <script>

        $('.btn-pdf').on('click', function(){
            var src = $(this).data('file');
            var title = $(this).data('title');
            $('#offcanvasScrollingLabel').text(title);
            $('#link').attr('src', src);
            $('#offcanvasScrolling').offcanvas('show');
        });

        $('.btn-att').on('click', function(){
            var att = $(this).data('file');
            var ext = $(this).data('ext');

            $('.btnForward').attr('data-attachment', $(this).data('filename'));
            $('#iframe').attr('src', att);
            $('#modalAtt').modal('show');
        });

        $('.btn-tambahEmail').on('click', function(){
            var id = $(this).data('id');
            var nip = $(this).data('nip');
            $('#id_email').val(id);
            $('#edit_nip').val(nip);
            $('#modalTambahEmail').modal('show');
        });

        $('.btnForward').on('click', function(){
            var filename = $(this).data('attachment');
            $('#edit_attachment').val(filename);
            $('#modalForward').modal('show');
        });

        $(document).ready(function(){
            $('[data-tooltip="tooltip"]').tooltip({
            "show" : 1000
             });
        });
        
        
    </script>
    @endsection
    </body>
</html>