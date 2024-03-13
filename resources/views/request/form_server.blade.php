
<div class="row">
    <div class="col-md-12 mb-2">
        <label for="">Jenis Layanan*</label>
        <select name="jenis" id="type" class="form-control" disabled required>
            <option value="">Pilih Jenis Layanan</option>
            <option value="Layanan Pembuatan Server Virtual/Hosting"  @if($server->jenis == 'Layanan Pembuatan Server Virtual/Hosting') selected @endif>Layanan Pembuatan server virtual/hosting</option>
            <option value="Layanan Pembuatan Subdomain"  @if($server->jenis == 'Layanan Pembuatan Subdomain') selected @endif>Layanan Pembuatan Subdomain</option>
        </select>
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Sistem / Aplikasi*</label>
        <input type="text" name="aplikasi" value="{{$server->aplikasi}}" disabled required class="form-control">
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Tanggal Dibutuhkan*</label>
        <input type="date" name="tanggal_dibutuhkan"disabled value="{{$server->tanggal_dibutuhkan}}" required class="form-control">
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Kebutuhan Permintaan*</label>
        <textarea name="kebutuhan" id="" cols="30" disabled rows="3"class="form-control" required>{{$server->kebutuhan}}</textarea>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">No HP*</label>
        <input type="text" name="no_hp" value="{{$server->no_hp}}" disabled required class="form-control">
    </div>
    <hr class="mt-2">
    <p>INFORMASI DEVELOPER</p>
    <hr>
    <div class="col-md-6 mb-2">
        <label for="">Nama*</label>
        <input type="text" name="nama_developer" disabled value="{{$server->nama_developer}}" required class="form-control">
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Unit Kerja*</label>
        <input type="text" name="unit_kerja" disabled value="{{$server->unit_kerja}}" required class="form-control">
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Jabatan*</label>
        <input type="text" name="jabatan" disabled value="{{$server->jabatan}}" required class="form-control">
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Bahasa Pemrograman*</label>
        <input type="text" name="pemrograman" disabled value="{{$server->pemrograman}}" required class="form-control">
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Analisa Dampak*</label>
        <select name="dampak" id="type" class="form-control" disabled required>
            <option value="">Pilih Kategori</option>
            <option value="Low" @if($server->dampak == 'Low') selected @endif>Low</option>
            <option value="Medium" @if($server->dampak == 'Medium') selected @endif>Medium</option>
            <option value="High" @if($server->dampak == 'High') selected @endif>High</option>
        </select>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Surat Permohonan / Nota Dinas*</label><br/>
        <button class="btn btn-light btn-pdf mb-2" data-file="{{url('')}}/uploads/{{$server->nota_dinas}}"  data-title="Nota Dinas" type="button">Lihat File</button>
        <!-- <input type="file" name="nota_dinas" class="form-control" required accept="application/pdf" max-size="2048"> -->
    </div>
</div>

        