@extends('layouts.master')

@section('content')
        <div class="row mb-2">
            <div class="col-12">
            <div class="card mini-stats-wid px-4 py-4">
                <div class="card-body">
                    <div class="media mb-4 text-center">
                        <div class="media-body">
                            <h3 class="fw-large">Form Request {{$layanan->layanan}}</h3>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                    <form action="{{url('tambah-request')}}" method="post" class="myForm" enctype="multipart/form-data">@csrf
                    <div class="row mt-4 py-4">
                        @php $opt = ''; @endphp
                        @foreach($field as $row)
                        @if($row->status_hapus != 1)
                        <div class="col-12 mb-2">
                            @if($row->jenis == 'input')
                                @if($row->tipe == "file")
                                <label for="basicpill-lastname-input">{{$row->label}}@if($row->required == 1) * @endif (PDF)</label>
                                <input type="{{$row->tipe}}" name="{{$row->nama}}" class="file-upload form-control" @if($row->required == 1) required="" @endif accept="application/pdf" max-size="2048">
                                @else
                                <label for="basicpill-lastname-input">{{$row->label}}@if($row->required == 1) * @endif</label>
                                <input type="{{$row->tipe}}" name="{{$row->nama}}" class="form-control" @if($row->required == 1) required="" @endif>
                                @endif
                            @elseif($row->jenis == 'textarea')
                                <label for="basicpill-lastname-input">{{$row->label}}@if($row->required == 1) * @endif</label>
                                <textarea name="{{$row->nama}}" class="form-control" id="" cols="30" rows="5" @if($row->required == 1) required="" @endif></textarea>
                            @elseif($row->jenis == 'select')
                            <label for="basicpill-lastname-input">{{$row->label}}@if($row->required == 1) * @endif</label>
                            <select name="{{$row->nama}}" class="form-control" id="" @if($row->required == 1) required="" @endif>
                                @php 
                                
                                    $opt = explode(',', $row->options); 
                                
                                @endphp
                                <option value="">Pilih {{$row->label}}</option>
                                @foreach($opt as $row )
                                    <option value="{{$row}}">{{$row}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <input type="hidden" name="id" value="{{$layanan->id}}">
                    <input type="hidden" name="jenis" value="{{$layanan->layanan}}">
                    <button class="submit btn btn-primary" type="submit" id="submitbutton">Submit</button>
                    </form>
                </div>
            </div>
        </div> 
    </div>
   
    @endsection
    </body>
</html>
