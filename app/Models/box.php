<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class box extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount', 'status', 'store_id', 'member_id'
    ];
}
