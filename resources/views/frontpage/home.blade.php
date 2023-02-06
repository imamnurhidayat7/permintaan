@extends('layouts.master')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="card">
                <img class="card-img img-fluid hero" src="{{url('')}}/images/bg1.jpg" style="height:400px; object-fit:cover;" alt="Card image">
                <div class="card-img-overlay text-center vertical-center">
                    <h1 class="card-title text-white mt-0 mb-4" style="font-size:24px;">Aplikasi Permintaan Layanan Pusdatin ATR/BPN</h1>
                    <p class="card-text text-white mb-4" style="font-size:16px;">Selamat datang kembali di aplikasi permintaan layanan Pusdatin ATR/BPN. Semangat melayani dengan profesional untuk meningkatkan kepercayaan masyarakat melalui transformasi digital.
</p>
                    <p class="card-text">
                        <a href="{{url('my-request')}}" class="btn btn-md btn-light">Lihat Request Saya</a>
                    </p>
                </div>
            </div>
            </div>
            <div class="col-12" id="request">
            <div class="mini-stats-wid">
                <div class="card-body">
                    <div class="media mb-4 text-center">
                        <div class="media-body">
                            <h2 class="fw-large">Katalog Layanan Pusdatin</h2>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                    <div class="row mt-4 py-4">
                        @if(!$layanan->isEmpty())
                        @foreach($layanan as $row)
                        <div class="col-md-3 col-sm-12" @if($row->isLayananPusat == 1 && Session::get('isUserPusat') != 1) style="display:none;" @endif>
                            <div class="card card-layanan overflow-hidden py-3">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-12 text-center py-4">
                                        <img src="{{url('')}}/images/icon.png" alt="" width="50px">
                                            <h5 class="mb-4 mt-4" style="min-height:40px">{{$row->layanan}}</h5>
                                            <a href="#" data-deskripsi="{{$row->deskripsi}}" data-id="{{$row->id}}" class="btnDetail btn btn-sm btn-primary @if($row->status != 1) disabled @endif">Lihat Persyaratan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                            <div class="card text-center py-5">
                                <p style="font-size:16px;"><i>Belum ada layanan yang tersedia</i></p>
                            </div>
                        @endif
                        
                    </div>
                    <!-- <div class="row mt-4 py-4">
                        @foreach($bidang as $row)
                        <div class="col-md-4 col-sm-12">
                            <div class="card card-layanan overflow-hidden py-3">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-12 text-center py-4">
                                        <img src="{{$row->icon}}" alt="" width="50px">
                                            <h5 class="mb-4 mt-4">{{$row->nama}}</h5>
                                            <a href="{{url('bidang', $row->id)}}" class="btn btn-sm btn-primary">Lihat Layanan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div> -->
                </div>
            </div>
        </div> 
    </div>

    <div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Persyaratan Layanan</h5>
                    <button type="button" class="btn-close tutup" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12" id="deskripsi">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="">
                    <button type="button" class="btn btn-light tutup" data-bs-dismiss="modal">Tutup</button>
                    <a href="" id="edit_id" class="btn btn-primary">Buat Request</a>
                </div>
            </div>
        </div>
    </div>
            


   
    @endsection
    @section('script')
    <script>

        var url = {!! json_encode(url('/')) !!}
        $('.btnDetail').on('click', function(e){
            e.preventDefault();
            $('#deskripsi').append($(this).data('deskripsi'));
            $('#edit_id').attr('href', url+'/layanan/request/'+$(this).data('id'));
            $('#modalDetail').modal('show');
        });
    
        $('.tutup').on('click', function(){
            $('#deskripsi').empty();
        });

        
    </script>
    @endsection
    </body>
</html>