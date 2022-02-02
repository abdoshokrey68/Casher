<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'create_id', 'store_id', 'discount', 'total', 'table_id', 'username',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function store()
    {
        return $this->belongsTo(store::class, 'store_id');
    }

    public function invoicedets()
    {
        return $this->hasMany(invoicedet::class, 'invoice_id');
    }

    public function getInvoice($store_id, $getfrom, $getto)
    {
        return invoice::where('store_id', $store_id)->where('created_at', '>=', $getfrom)->where('created_at', '<=', $getto)->select('create_id', 'store_id', 'discount', 'total', 'UserName', 'table_id', 'created_at')->get()->toArray();
    }
}
