<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        // $user = User::find(Auth::id());
        // $user->password =  Hash::make($user->password);
        // $user->save();
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
            'store_id'      => 'required',
            'amount'        => 'required',
            'status'        => 'required',
            'password'      => 'required',
        ]);
        // if ($request->password == Auth::user()->password) {
        $store = store::find($request->store_id);
        if ($store) {
            $box = new box();
            $box->amount = $request->amount;
            $box->store_id = $request->store_id;
            $box->member_id = Auth::id();
            $box->status = $request->status == 0 ? 1 : 0;
            $box->save();
            return $box;
        } else {
            return 'false';
        }
        // } else {
        //     return 'false';
        // }
    }
}
