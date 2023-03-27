
<div class="row">
    <div class="col-md-6 mb-2">
        <label for="">Jenis Layanan</label>
        <select name="jenis" id="type" disabled class="form-control" required>
            <option value="">Pilih Jenis Layanan</option>
            <option value="VPN" @if($akses->jenis == 'VPN') selected @endif>VPN</option>
            <option value="Akses Jaringan" @if($akses->jenis == 'Akses Jaringan') selected @endif>Akses Jaringan</option>
        </select>
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Kategori</label>
        <select name="kategori" id="kategori" disabled class="form-control" required>
            <option value="">Pilih Kategori</option>
            <option value="Internal" @if($akses->kategori == 'Internal') selected @endif>Internal</option>
            <option value="Pihak Ketiga" @if($akses->kategori == 'Pihak Ketiga') selected @endif>Pihak Ketiga</option>
        </select>
    </div>
    @if($akses->kategori == 'Internal')
    @foreach($akses->userAkses as $row)
    <div class="col-md-6 mb-2">
        <label for="">Nama</label>
        <input type="text" name="nama" value="{{$row->nama}}" disabled class="form-control" required>
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Email</label>
        <input type="text" name="nama" value="{{$row->email}}" disabled class="form-control" required>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Satuan Kerja*</label>
        <textarea name="satker" id="" cols="3" rows="3" class="form-control" disabled>{{$row->satker}}</textarea>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Peralatan yang digunakan*</label>
        <input type="text" name="peralatan" value="{{$row->peralatan}}" disabled class="form-control" required>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">Mac Address*</label>
        <input type="text" name="mac_address" value="{{$row->mac_address}}" disabled class="form-control" required>
    </div>
    <div class="col-md-12 mb-2">
        <label for="">IP yang ingin diakses*</label>
        <textarea name="ip_address" disabled cols="30" rows="3" class="form-control">{{$row->ip_address}}</textarea>
    </div>
    @endforeach
    @else
    <hr class="mt-4">
    <h5 class="text-center">DATA PEKERJAAN</h5>
    <hr>
    <div class="row">
    <div class="col-md-6 mb-2">
        <label for="">Nama Pekerjaan</label>
        <input type="text" name="nama_pekerjaan" disabled value="{{$akses->nama_pekerjaan}}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Perusahaan / Vendor</label>
        <input type="text" name="perusahaan" disabled value="{{$akses->perusahaan}}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Tanggal Mulai</label>
        <input type="text" id="datepicker1" disabled value="{{$akses->tanggal_mulai}}" name="tanggal_mulai" class="form-control" required>
    </div>
    <div class="col-md-6 mb-2">
        <label for="">Tanggal Selesai</label>
        <input type="text" id="datepicker2" disabled value="{{$akses->tanggal_selesai}}" name="tanggal_selesai" class="form-control" required>
    </div>
    <div class="col-md-6 mb-4">
    <label for="">NDA*</label><br/>
    <button class="btn btn-light btn-pdf mb-2" data-file="{{url('')}}/uploads/{{$akses->nda}}"  data-title="NDA" type="button">Lihat File</button><br/>
    </div>
    <div class="col-md-6 mb-4">
    <label for="">Surat Tugas*</label><br/>
    <button class="btn btn-light btn-pdf mb-2" data-file="{{url('')}}/uploads/{{$akses->surat_tugas}}"  data-title="NDA" type="button">Lihat File</button><br/>
    </div>
</div>

    <hr class="mt-4">
    <h5 class="text-center">DATA PERSONEL</h5>
    <hr>

    <table id="datatable2" class="table table-bordered dt-responsive mt-2  nowrap w-100">
    <thead>
        <tr>
        <th>Nama</th>
        <th>Peralatan</th>
        <th>Mac Address</th>
        <th>Permintaan Akses</th>
        </tr>
    </thead>
    <tbody>
    @foreach($akses->userAkses as $row)
        
        <tr>
            <td>{{$row->nama}}</td>
            <td>{{$row->peralatan}}</td>
            <td>{{$row->mac_address}}</td>
            <td>{{$row->ip_address}}</td>
        </tr>
        
    @endforeach
    </tbody>
</table>
@endif
</div>
