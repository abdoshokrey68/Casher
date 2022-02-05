<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class audience extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'store_id',
        'member_id',
    ];
}
