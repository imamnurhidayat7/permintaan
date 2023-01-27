<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAkses extends Model
{
    use HasFactory;
    protected $table = "request_akses";

    protected $fillable = [
        'id_request',
        'jenis',
        'kategori',
        'nama_pekerjaan',
        'perusahaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'kontak',
    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }

    public function userAkses()
    {
        return $this->hasMany('App\Models\DetailRequestAkses', 'id_request_akses', 'id');
    }

    
}
