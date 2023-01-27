<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestEmail extends Model
{
    use HasFactory;
    protected $table = "request_email";

    protected $fillable = [
        'id_request',
        'jenis',
        'nota_dinas'
    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }

    public function detailRequest()
    {
        return $this->hasMany('App\Models\DetailRequestEmail', 'id_request_email', 'id');
    }
}
