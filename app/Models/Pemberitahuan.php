<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemberitahuan extends Model
{
    use HasFactory;
    protected $table = "pemberitahuan";

    protected $fillable = [
        'id_user',
        'judul',
        'pesan',
        'url',
        'status'
    ];

}
