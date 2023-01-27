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
                        <button type="" class="btn @if($request->status=='Request Diajukan') btn-warning @elseif($request->status=='Ditolak') btn-danger @else btn-success @endif btn-sm btn-rounded waves-effect waves-light">{{$request->status}}</button>
                        <button type="" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" >{{$request->tahapan}}</button><br/>
                        
                       
                        <!-- <a class="btn btn-success btn-sm waves-effect mt-2 mr-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalEdit" data-tooltip="tooltip" title="Pesan"><i class="mdi mdi-wechat d-block font-size-16"></i></a> -->
                            
                        <a class="btn btn-info btn-sm waves-effect mt-2 mr-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalUbahStatus" data-tooltip="tooltip" title="Pesan"><i class="mdi mdi-wechat d-block font-size-16"></i></a>
                            
                        <!-- <a class="btn btn-primary btn-sm waves-effect mt-2 waves-light" data-bs-toggle="modal" data-bs-target="#modalEskalasi"><i class="mdi mdi-pencil d-block font-size-16"></i> </a> -->
                        </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-md-8">
                <div class="card" style="min-height:600px;">
                    <div class="card-body">
                        <!-- Nav tabs -->


                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Requester</label>
                                            <input type="text" readonly name="name" value="{{$request->user->name}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">Layanan</label>
                                            <input type="text" readonly name="email" value="{{$request->layanan->layanan}}" class="form-control" required="">
                                        </div>
                                    </div>
                                    @foreach($request->layanan->fields as $row)
                                    <div class="col-12 mb-2">
                                        @foreach($request->meta as $row2)
                                            @if($row->nama == $row2->nama)
                                                @if($row->jenis == 'input')
                                                    <label for="basicpill-lastname-input">{{$row->label}}</label><br/>
                                                    @if($row->tipe=='file')
                                                    <button class="btn btn-default btn-pdf" data-file="{{url('')}}/uploads/{{$row2->value}}"  data-title="{{$row->label}}" type="button">Lihat File</button>
                                                    <!-- <a href="" class="btn btn-sm btn-primary">Lihat File</a> -->
                                                    @else
                                                    <input type="{{$row->tipe}}" readonly name="{{$row->nama}}" value="{{$row2->value}}" class="form-control" required="">
                                                    @endif
                                                @elseif($row->jenis == 'textarea')
                                                    <label for="basicpill-lastname-input">{{$row->label}}</label>
                                                    <textarea readonly name="{{$row->nama}}" class="form-control" id="" cols="30" rows="5">{{$row2->value}}</textarea>
                                                @else
                                                <label for="basicpill-lastname-input">{{$row->label}}</label>
                                                <input type="text" readonly value="{{$row2->value}}" class="form-control">
                                                @endif
                                            @endif
                                        @endforeach 
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div>
                            <div class="chat-conversation p-3">
                                <ul class="list-unstyled mb-0" data-simplebar="init" style="max-height: 300px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: scroll;"><div class="simplebar-content" style="padding: 0px; ">
                                    <li> 
                                        <div class="chat-day-title">
                                            <span class="title">Riwayat Eskalasi</span>
                                        </div>
                                    </li>
                                    @if($disposisi->isEmpty())
                                    <div class="text-center" style="position:relative; height:200px;">
                                        <h5 style="  margin: 0;position: absolute;top: 50%;left: 50%; transform: translate(-50%, -50%);">
                                            Belum ada riwayat eskalasi
                                        </h5>
                                    </div>
                                    @else
                                    @php $count = 0; @endphp
                                    @foreach($disposisi as $row)
                                    
                                    @if($row->pengirim->id == Session::get('id') || $row->penerima->id == Session::get('id') )
                                    @php $count++; @endphp
                                    <li @if($row->pengirim->id == Session::get('id')) class="right" @endif>
                                        <div class="conversation-list">
                                            <div class="ctext-wrap">
                                                <div class="conversation-name">Dari : {{$row->pengirim->name}}</div>
                                                <div class="conversation-name">Ke : {{$row->penerima->name}}</div>
                                                <p>
                                                    {{$row->pesan}}
                                                </p>
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
                                @if($request->status != 'Selesai' && $request->status != 'Ditutup' && $request->status != 'Ditolak')
                                @if(Session::get('id') != $request->id_pic)
                                <form action="{{url('tambah-disposisi')}}" class="myForm" method="post">@csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="position-relative mb-2">
                                                <label>Tujuan</label>
                                                <select name="id_user_disposisi" id="" class="form-control" required>
                                                    <option value="">Pilih Tujan Eskalasi</option>
                                                    @foreach($user as $row)
                                                    <option value="{{$row->id}}">{{$row->name}} - {{$row->jabatan}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="position-relative mb-4">
                                                <label for="">Pesan</label>
                                                <textarea name="pesan" class="form-control" id="" cols="50" rows="3" required></textarea>
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
                                    <p class="text-center">Request ditutup pada {{$request->updated_at}}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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

            <!-- Static Backdrop Modal -->
            <div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="font-size-15">{{$request->user->name}}</h5>
                            <!-- <p class="text-muted mb-0">{{$request->created_at}}</p> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="card">
                                    <div>
                                        <div class="chat-conversation p-3">
                                            <ul class="list-unstyled mb-0" data-simplebar="init" style="max-height: 486px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                                <li> 
                                                    <div class="chat-day-title">
                                                        <span class="title">Riwayat Pesan</span>
                                                    </div>
                                                </li>
                                                @foreach($catatan as $row)
                                                <li @if($row->pengirim->id == Session::get('id')) class="right" @endif>
                                                    <div class="conversation-list">
                                                        <div class="ctext-wrap">
                                                            <div class="conversation-name">{{$row->pengirim->name}}</div>
                                                            <p>
                                                                {{$row->pesan}}
                                                            </p>
                                                            @if($row->attachment != '')
                                                            <a class="btn-att" href="#" data-file="{{url('')}}/uploads/{{$row->attachment}}"  data-title="Attachment">Lihat Attachment</a>
                                                            @endif
    
                                                            <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i>{{$row->created_at}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                <!-- <li>
                                                    <div class="conversation-list">
                                                        <div class="dropdown">
    
                                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                              </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Copy</a>
                                                                <a class="dropdown-item" href="#">Save</a>
                                                                <a class="dropdown-item" href="#">Forward</a>
                                                                <a class="dropdown-item" href="#">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="ctext-wrap">
                                                            <div class="conversation-name">Steven Franklin</div>
                                                            <p>
                                                                Hello!
                                                            </p>
                                                            <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:00</p>
                                                        </div>
                                                        
                                                    </div>
                                                </li>
    
                                                <li class="right">
                                                    <div class="conversation-list">
                                                        <div class="dropdown">
    
                                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                              </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Copy</a>
                                                                <a class="dropdown-item" href="#">Save</a>
                                                                <a class="dropdown-item" href="#">Forward</a>
                                                                <a class="dropdown-item" href="#">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="ctext-wrap">
                                                            <div class="conversation-name">Henry Wells</div>
                                                            <p>
                                                                Hi, How are you? What about our next meeting?
                                                            </p>
    
                                                            <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:02</p>
                                                        </div>
                                                    </div>
                                                </li> -->

                                                  
                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 645px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>
                                        </div>
                                        @if(Session::get('role') == 'customerservice' && $request->status != 'Selesai')
                                        <div class="p-3 chat-input-section">
                                            <form action="{{url('tambah-catatan')}}" id="myForm" class="myForm" method="post" enctype="multipart/form-data">@csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row mb-2">
                                                        <div class="position-relative">
                                                            <textarea name="pesan" class="form-control" id="" cols="50" rows="3" required></textarea>
                                                        </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="position-relative">
                                                            <input class="form-control" type="file" name="attachment" id="formFile" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                                                            <!-- <label for="">*pdf/jpg/png</label> -->
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                    <input type="hidden" name="id_request" value="{{$request->id}}">
                                                    <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                                                        <button type="submit" id="submit" class="submit btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Kirim</span> <i class="mdi mdi-send"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Disposisi -->
            <div class="modal fade" id="modalUbahStatus" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{url('/cs/request/ubah-status')}}"  method="post" enctype="multipart/form-data">@csrf
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
                                                        <p>
                                                            {{$row->pesan}}
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
                                @if($request->id_user_disposisi == '' && $request->status != 'Selesai' && $request->status != 'Ditutup' && $request->status != 'Ditolak')
                                <div class="col-md-12 mb-3">
                                        <label>Status</label>
                                        <select name="status" id="" class="form-control" required>
                                            <option value="">Pilih Status</option>   
                                            <option value="Request Diajukan" @if($request->status == 'Request Diajukan') selected @endif>Request Diajukan</option>
                                            <option value="Ditolak" @if($request->status == 'Ditolak') selected @endif>Ditolak</option>
                                            <option value="Ditunda" @if($request->status == 'Ditunda') selected @endif>Ditunda</option>
                                            <option value="Selesai" @if($request->status == 'Selesai') selected @endif>Selesai</option>
                                        </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Pesan</label>
                                    <textarea name="pesan" id="" cols="30" rows="4" class="form-control" required></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Attachment</label>
                                    <input type="file" name="attachment" class="form-control" accept="application/pdf, image/jpg, image/png, image/jpeg" max-size="2048">
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_request" value="{{$request->id}}">
                            <input type="hidden" name="id_pengirim" value="{{Session::get('id')}}">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            @if($request->id_user_disposisi == '' && $request->status != 'Selesai' && $request->status != 'Ditutup' && $request->status != 'Ditolak')
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
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Attachment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        
                            <iframe id="iframe" src="" width="100%" height="800px"></iframe>
                        
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
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
            $('#iframe').attr('src', att);
            $('#modalAtt').modal('show');
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