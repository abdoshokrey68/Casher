<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class invoicesett extends Model
{
    use HasFactory;

    protected $fillable = [
        'autotax',
        'tax_record',
        'tax_card',
        'file_no',
        'tax',
        'product_rtn',
        'message_en',
        'message_ar',
        'store_id',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(store::class, 'store_id');
    }
}
