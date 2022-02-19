<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoicedet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'product_id', 'price', 'quantity',  'invoice_id', 'store_id'
    ];

    public function invoice()
    {
        return $this->belongsTo(invoice::class, 'invoice_id');
    }
}
