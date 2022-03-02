<?php

namespace App\Http\Controllers;

use App\Models\audience;
use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class audienceApi extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'store_id'      => 'required'
        ]);
        $user = User::find(Auth::id());
        $store = store::find($request->store_id);
        if ($user) {
            if ($store) {
                if ($store->manager_id == $user->id) {
                    $audience =  audience::where('store_id', $request->store_id)->get();
                    return $audience;
                } else {
                    return 'false1';
                }
            } else {
                return 'false2';
            }
        } else {
            return 'false3';
        }
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'store_id'  => 'required',
            'phone'     => 'required'
        ]);
        $user = User::find(Auth::id());
        $store = store::find($request->store_id);
        if ($store) {
            if ($store->manager_id == $user->id) {
                $audience = new audience();
                $audience->store_id = $request->store_id;
                $audience->phone = $request->phone;
                if (Auth::id()) {
                    $audience->member_id = Auth::id();
                }
                $audience->save();
                return $audience;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'store_id'  => 'required',
            'audience_id'  => 'required',
        ]);
        $user = User::find(Auth::id());
        $store = store::find($request->store_id);
        if ($store) {
            if ($request->audience_id == 0) {
                $audiences = audience::where('store_id', $request->store_id)->get();
                foreach ($audiences as $key => $audience) {
                    $audience->delete();
                }
                return ' Deleted Successfuly ';
            } else {
                $audience = audience::find($request->audience_id);
                if ($audience) {
                    $audience->delete();
                    return ' Deleted Successfuly ';
                } else {
                    return abort(404);
                }
            }
        } else {
            return 'false';
        }
    }
}
