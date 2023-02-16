<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRequestAkses extends Model
{
    use HasFactory;
    protected $table = "detail_request_akses";

    protected $fillable = [
        'id_request_akses',
        'nama',
        'peralatan',
        'ip_address',
        'mac_address',
        'email',
        'nip',
        'satker'
    ];

    public function requestAkses()
    {
        return $this->belongsTo('App\Models\RequestAkses', 'id_request_akses', 'id');
    }
}
