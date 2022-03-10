<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\box;
use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class boxApi extends Controller
{
    public function getboxinfo(Request $request)
    {
        $this->validate($request, [
            'store_id'      => 'required',
        ]);
        $store = store::find($request->store_id);
        if ($store) {
            $boxinfo = box::where('store_id', $store->id)->latest('created_at')->first();
            return [
                'box'   => $boxinfo,
                'username'  => Auth::user()->name,
                'password'  => Auth::user()->password,
            ];
        } else {
            return 'false';
        }
    }

    public function addtobox(Request $request)
    {
        $this->validate($request, [
            'password'      => "required"
        ]);
        $user = Auth::user();
        if (Hash::check($request->password, $user->password)) {
            $this->validate($request, [
                'store_id'      => 'required',
                'amount'        => 'required',
                'status'        => 'required',
            ]);
            $positionApi = new positionApi();
            $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'box_add');

            if ($check) {
                $store = store::find($request->store_id);
                $box = new box();
                $box->amount = $request->amount;
                $box->store_id = $request->store_id;
                $box->member_id = Auth::id();
                $box->status = $request->status == 0 ? 1 : 0;
                $box->save();
                $historyApi = new historyApi;
                if ($request->status == 0) {
                    $des_ar = ' تم إستلام الصندوق ';
                    $des_en = 'The box has been received';
                } else {
                    $des_ar = ' تم تسليم الصندوق  ';
                    $des_en = 'The box has been delivered';
                }
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return 'done';
            } else {
                return abort(401);
            }
        } else {
            return abort(401);
        }
    }
}
