<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $table = "layanan";

    protected $fillable = [
        'layanan',
        'deskripsi',
        'status',
        'icon',
        'id_pic',
        'id_bidang',
        'id_pelaksana',
        'generate',
        'file',
        'isLayananPusat'
    ];

    
    public function fields()
    {
        return $this->hasMany('App\Models\LayananField', 'layanan_id', 'id');
    }

    public function pelaksana()
    {
        return $this->belongsTo('App\Models\User', 'id_pelaksana', 'id');
    }

    public function pic()
    {
        return $this->belongsTo('App\Models\User', 'id_pic', 'id');
    }

    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang', 'id_bidang', 'id');
    }

    public function approver()
    {
        return $this->hasOne('App\Models\LayananApprover', 'layanan_id', 'id');
    }

}
