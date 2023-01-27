<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    use HasFactory;
    protected $table = "approver";

    protected $fillable = [
        'nama',
        'email',
        'nip',
    ];

}
