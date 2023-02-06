<div class="row">
    <div class="col-md-12 mb-2">
        <label for="">Jenis Layanan*</label>
        <input type="text" name="jenis" disabled value="{{$jaringan->jenis}}" required class="form-control">
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Pesan*</label>
        <textarea name="pesan" id="" cols="30" rows="3"class="form-control" @if($request->status != 'Ditolak') disabled @endif required>{{$jaringan->pesan}}</textarea>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Surat Permohonan / Nota Dinas*</label><br/>
        <button class="btn btn-light btn-pdf mb-2" data-file="{{url('')}}/uploads/{{$jaringan->nota_dinas}}"  data-title="Nota Dinas" type="button">Lihat File</button>
        @if($request->status == 'Ditolak')
        <label for="">Ganti File</label>
        <input type="file" name="nota_dinas" class="form-control" accept="application/pdf" max-size="2048">
        @endif
    </div>
</div>