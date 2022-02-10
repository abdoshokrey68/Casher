<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
// use App\Models\invoice;
// use App\Models\section;

class store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'discount',
        'image',
        'thumbnail',
        'cover',
        'audience',
        'location',
        'phone',
        'email',
        'currency',
        'manager_id'
    ];

    public function getNameAttribute($value)
    {
        return Str::title($value);
    }

    public function getSlugAttribute($value)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->attributes['name'])));
    }

    // ==============================================================================
    // ========================= MODEL RELASHANSHIPS ================================
    // ==============================================================================

    public function invoices(): HasMany
    {
        return $this->hasMany(invoice::class, 'store_id');
    }

    public function sections()
    {
        return $this->hasMany(section::class, 'store_id');
    }

    public function tables()
    {
        return $this->hasMany(table::class, 'store_id');
    }

    // ==============================================================================
    // ========================= MODEL SET ATTRIBUTES ================================
    // ==============================================================================

    public function getSections()
    {
        return $this->setAttribute('sections', $this->sections());
    }
}
