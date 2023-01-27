<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = "riwayat";

    protected $fillable = [
        'tahapan',
        'id_request',
        'keterangan'
    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }

}
