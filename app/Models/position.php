<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class position extends Model
{
    use HasFactory;
    // [0]    => NOTHING ||  [1]     => SHOW || [2]  => ADD || [3] => EDIT || [4] => DELETE
    protected $fillable = [
        'position',
        'store_id',
        'member_id',
        'invoice_show',
        'invoice_add',
        'invoice_edit',
        'invoice_delete',
        'section_show',
        'section_add',
        'section_edit',
        'section_delete',
        'member_show',
        'member_add',
        'member_edit',
        'member_delete',
        'product_show',
        'product_add',
        'product_edit',
        'product_delete',
        'table_show',
        'table_add',
        'table_edit',
        'table_delete',
        'history_show',
        'history_delete',
        'menu_edit',
        'store_edit',
        'box_add',
    ];

    /**
     * Get the user that owns the position
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(store::class, 'store_id');
    }

    public function getmember(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
