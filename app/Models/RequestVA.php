<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestVA extends Model
{
    use HasFactory;
    protected $table = "request_va";

    protected $fillable = [
        'id_request',
        'aplikasi',
        'url',
        'akun',
        'nota_dinas'

    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }
}
