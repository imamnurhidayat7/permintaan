<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestKeamananSiber extends Model
{
    use HasFactory;
    protected $table = "request_keamanan_siber";

    protected $fillable = [
        'id_request',
        'jenis',
        'pesan',
        'nota_dinas'
    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }
}
