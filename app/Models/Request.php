<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $table = "request";

    protected $fillable = [
        'layanan_id',
        'user_id',
        'status',
        'keterangan',
        'tahapan',
        'id_user_disposisi',
        'no_req',
        'approval',
        'waktu_approval',
        'jenis',
        'type',
        'status'
    ];

    public function layanan()
    {
        return $this->belongsTo('App\Models\Layanan', 'layanan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function pelaksana()
    {
        return $this->belongsTo('App\Models\User', 'id_user_disposisi', 'id');
    }
    
    public function meta()
    {
        return $this->hasMany('App\Models\LayananMeta', 'request_id', 'id');
    }
}
