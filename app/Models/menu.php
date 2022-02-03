<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'design_no',
        'background_co',
        'text_co',
        'heading_co',
    ];
}
