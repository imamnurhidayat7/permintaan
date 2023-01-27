<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananField extends Model
{
    use HasFactory;
    protected $table = "layanan_fields";

    protected $fillable = [
        'layanan_id',
        'nama',
        'tipe',
        'jenis',
        'label',
        'options',
        'required',
        'status_hapus'
    ];

    public function meta()
    {
        return $this->hasOne('App\Models\LayananMeta', 'nama', 'nama');
    }

    

}
