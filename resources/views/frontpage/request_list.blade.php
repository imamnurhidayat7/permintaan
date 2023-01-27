@extends('layouts.master')

@section('content')
        <div class="row mb-2">
            <div class="col-12" id="request">
            <div class="mini-stats-wid">
                <div class="card-body">
                    <div class="media mb-4 text-center">
                        <div class="media-body">
                            <h2 class="fw-large">Layanan Bidang {{$bidang->nama}}</h2>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                    <div class="row mt-4 py-4">
                        @if(!$layanan->isEmpty())
                        @foreach($layanan as $row)
                        <div class="col-md-4 col-sm-12">
                            <div class="card card-layanan overflow-hidden py-3">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-12 text-center py-4">
                                        <img src="{{url('')}}/images/icon.png" alt="" width="50px">
                                            <h5 class="mb-4 mt-4">{{$row->layanan}}</h5>
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

        $('.btnDetail').on('click', function(e){
            $('#deskripsi').append($(this).data('deskripsi'));
            $('#edit_id').attr('href', 'https://permintaan.atrbpn.go.id/layanan/request/'+$(this).data('id'));
            $('#modalDetail').modal('show');
        });
    
        $('.tutup').on('click', function(){
            $('#deskripsi').empty();
        });

        
    </script>
    @endsection
    </body>
</html>