<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRequestEmail extends Model
{
    use HasFactory;
    protected $table = "detail_request_email";

    protected $fillable = [
        'id_request_email',
        'nama',
        'nip',
        'email',
        'status',
    ];

    public function requestEmail()
    {
        return $this->belongsTo('App\Models\RequestEmail', 'id_request_email', 'id');
    }
}
