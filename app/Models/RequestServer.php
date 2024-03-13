<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestServer extends Model
{
    use HasFactory;
    protected $table = "request_server";

    protected $fillable = [
        'id_request',
        'jenis',
        'aplikasi',
        'tanggal_dibutuhkan',
        'kebutuhan',
        'nama_developer',
        'unit_kerja',
        'jabatan',
        'pemrograman',
        'dampak',
        'nota_dinas',
        'no_hp'

    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }
}
