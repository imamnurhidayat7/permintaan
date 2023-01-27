<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $table = "catatan";

    protected $fillable = [
        'id_request',
        'id_pengirim',
        'pesan',
        'attachment'
    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'id_request', 'id');
    }

    public function pengirim()
    {
        return $this->belongsTo('App\Models\User', 'id_pengirim', 'id');
    }
}
