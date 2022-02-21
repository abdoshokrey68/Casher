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
        'invoice',  // [ 0 ] || [ 1 ] || [ 2 ] || [ 3 ] || [ 4 ]
        'section',  // [ 0 ] || [ 1 ] || [ 2 ] || [ 3 ] || [ 4 ]
        'product',  // [ 0 ] || [ 1 ] || [ 2 ] || [ 3 ] || [ 4 ]
        'table',    // [ 0 ] || [ 1 ] || [ 2 ] || [ 3 ] || [ 4 ]
        'member',   // [ 0 ] || [ 1 ] || [ 2 ] || [ 3 ] || [ 4 ]
        'store',    // [ 0 ] || [ 1 ] || [ 3 ]
        'history',  // [ 0 ] || [ 1 ]
        'menu',     // [ 0 ] || [ 1 ] || [ 3 ]
        // 'box',      // [ 0 ] || || [ 3 ]
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
