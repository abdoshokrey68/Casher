<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\position;
use Illuminate\Http\Request;

class positionApi extends Controller
{
    public function checkPositionRoute($store_id, $member_id, $position)
    {
        $check = position::where('member_id', $member_id)->where('store_id', $store_id)->select($position)->first();
        if ($check->$position)
            return true;
        else
            return false;
    }
}
