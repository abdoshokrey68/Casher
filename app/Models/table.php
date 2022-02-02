<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table extends Model
{
    use HasFactory;

    protected $fillabe = [
        'name', 'slug', 'store_id', 'status'
    ];

    public function store()
    {
        return $this->belongsTo(store::class, 'store_id');
    }
}
