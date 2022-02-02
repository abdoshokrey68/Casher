<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'image', 'stock', 'section_id', 'store_id'
    ];

    public function section()
    {
        return $this->belongsTo(section::class, 'section_id');
    }

    public function store()
    {
        return $this->belongsTo(store::class, 'store_id');
    }

    public function getProducts($store_id)
    {
        return product::where('store_id', $store_id)->select('name', 'description', 'price', 'stock', 'section_id')->get()->toArray();
    }
}
