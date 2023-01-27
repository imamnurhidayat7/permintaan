<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananMeta extends Model
{
    use HasFactory;
    protected $table = "layanan_meta";

    protected $fillable = [
        'request_id',
        'nama',
        'value',
        'type',
        'status'
    ];
}
