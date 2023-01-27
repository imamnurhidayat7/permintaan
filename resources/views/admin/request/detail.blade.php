@extends('admin.master_admin')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card py-4">
                        <div class="card-body text-center">
                        <h4 class="fw-medium mb-2">Request #{{$request->id}}</h4>
                        <p>Tanggal dibuat : {{$request->created_at}}</p>
                        <button type="button" class="btn @if($request->status=='Dalam Proses') btn-warning @else btn-success @endif btn-sm btn-rounded waves-effect waves-light">{{$request->status}}</button>
                        <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">{{$request->tahapan}}</button><br/>
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
                                </div>
                            </div>
                            @if($request->status == 'Berkas Lengkap' && Session::get('id') == $request->layanan->id_pic)
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

                                                <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i>{{$row->created_at}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach 
                                    @endif   
                                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 645px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>
                            </div>
                            @if($request->status == 'Selesai')
                            <div class="p-3 chat-input-section">
                                <p class="text-center">Request ditutup pada {{$request->updated_at}}</p>
                            </div>
                            @endif
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

    </script>
    @endsection
    </body>
</html>