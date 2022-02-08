<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'qrcode_name',
        'design_no',
        'background_co',
        'text_co',
        'heading_co',
        'des_co',
        'icon_co',
        'price_co',
    ];

    public function store()
    {
        return $this->belongsTo(store::class, 'store_id');
    }
}
