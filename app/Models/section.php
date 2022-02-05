<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\store;

class section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'store_id', 'discount'
    ];

    public function store()
    {
        return $this->belongsTo(store::class, 'store_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(product::class, 'section_id');
    }
}
