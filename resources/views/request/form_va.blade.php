<div class="row">
    <div class="col-md-6 mb-2">
        <label for="">Sistem / Aplikasi*</label>
        <input type="text" name="aplikasi" @if($request->status != 'Ditolak') disabled @endif value="{{$va->aplikasi}}" required class="form-control">
    </div>
    <div class="col-md-6 mb-2">
        <label for="">URL Aplikasi*</label>
        <input type="text" name="url" value="{{$va->url}}" @if($request->status != 'Ditolak') disabled @endif required class="form-control">
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Akun (Username dan Password)*</label>
        <textarea name="akun" id="" cols="30" rows="3"class="form-control" @if($request->status != 'Ditolak') disabled @endif required>{{$va->akun}}</textarea>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Surat Permohonan / Nota Dinas*</label><br/>
        <button class="btn btn-light btn-pdf mb-2" data-file="{{url('')}}/uploads/{{$va->nota_dinas}}"  data-title="Nota Dinas" type="button">Lihat File</button>
        @if($request->status == 'Ditolak')
        <label for="">Ganti File</label>
        <input type="file" name="nota_dinas" class="form-control" accept="application/pdf" max-size="2048">
        @endif
    </div>
</div>