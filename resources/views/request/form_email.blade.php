<div class="col-md-6 mb-2">
    <label for="">Jenis Layanan</label>
    <select name="jenis" id="type" disabled class="form-control" required>
        <option value="">Pilih Jenis Layanan</option>
        <option value="Pendaftaran Email Baru" @if($email->jenis == 'Layanan Registrasi Email ATR/BPN Individu atau Satker') selected @endif>Layanan Registrasi Email ATR/BPN Individu atau Satker</option>
        <option value="Penonaktifan Email" @if($email->jenis == 'Layanan Penonaktifan Email ATR/BPN Individu atau Satker') selected @endif>Layanan Penonaktifan Email ATR/BPN Individu atau Satker</option>
    </select>
</div>
<div class="col-md-6 mb-2">
<label for="">Jenis Email</label>
<input type="text" class="form-control" value="{{$email->jenis_email}}" disabled>
</div>
<div class="col-md-12 mb-4">
    <label for="">Surat Permohonan / Nota Dinas</label><br/>
    <button class="btn btn-light btn-pdf mb-2" data-file="{{url('')}}/uploads/{{$email->nota_dinas}}"  data-title="Nota Dinas" type="button">Lihat File</button><br/>
    @if($request->status == 'Ditolak')
    <label for="">Ganti File</label>
    <input type="file" name="nota_dinas" class="form-control" accept="application/pdf" max-size="2048">
    @endif
</div>
@if($email->jenis_email == 'Email Pegawai' || $email->jenis_email == '')
<table id="datatable2" class="table table-bordered mt-2 ">
    <thead>
        <tr>
        <th>Nama</th>
        <th>NIP</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($email->detailRequest as $row)
       
        <tr>
            <td>{{$row->nama}}</td>
            <td>{{$row->nip}}</td>
            <td>{{$row->status}} {{$row->email}}</td>
            <td>
                @if($row->status == 'Belum Ada Email')
                    @if($request->status == 'Sedang Diproses' && Session::get('id') == $request->id_user_disposisi)
                    <a class="btn btn-success btn-sm waves-effect mt-2 mr-2 waves-light btn-tambahEmail" data-id="{{$row->id}}" data-nip="{{$row->nip}}" data-tooltip="tooltip" title="Tambah Email"><i class="mdi mdi-plus d-block font-size-16"></i></a>    
                    @endif
                @endif
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
@else
<table id="datatable2" class="table table-bordered mt-2 ">
    <thead>
        <tr>
        <th>Kantor</th>
        <th>Email</th>
        </tr>
    </thead>
    <tbody>
    @foreach($email->detailRequest as $row)
       
        <tr>
            <td>{{$row->nama}}</td>
            <td>{{$row->email}}</td>
        </tr>

    @endforeach
    </tbody>
</table>
@endif


