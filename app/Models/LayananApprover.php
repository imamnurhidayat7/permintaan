<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananApprover extends Model
{
    use HasFactory;
    protected $table = "layanan_approver";

    protected $fillable = [
        'approver_id',
        'layanan_id',
    ];

    public function approver()
    {
        return $this->belongsTo('App\Models\User', 'approver_id', 'id');
    }

    public function layanan()
    {
        return $this->belongsTo('App\Models\Layanan', 'layanan_id', 'id');
    }

}
