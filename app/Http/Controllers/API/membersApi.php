<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\invoice;
use App\Models\invoicedet;
use App\Models\position;
use App\Models\product;
use App\Models\section;
use App\Models\store;
use App\Models\table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class membersApi extends Controller
{
    public function index(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return User::where('store_id', $store_id)->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function getmember(Request $request)
    {
        $member_id = $request->member_id;
        $user = User::find($member_id);
        if ($user) {
            $store = store::find($user->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    return $user;
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:rfc,dns',
            'position' => 'required',
            'store_id' => 'required',
        ]);
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $user = User::where('email', $request->email)->first();
                $this->createPosition($user->id, $store->id, $request->position);

                $historyApi = new historyApi;
                $des_ar = " تم إضافة عميل جديد للمتجر ";
                $des_en = " A new customer has been added to the store ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());

                return 'An employee has been added successfully';
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }
    public function edit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:rfc,dns',
            'member_id' => 'required',
            'position' => 'required',
            'store_id' => 'required',
        ]);
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $user = User::where('email', $request->email)->first();
                $user->store_id = $request->store_id;
                $user->position = $request->position;
                $user->save();

                $historyApi = new historyApi;
                $des_ar = " تم تعديل بيانات العميل '$user->email' ";
                $des_en = " '$user->email' customer data has been modified ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return 'An employee has been added successfully';
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
            'member_id' => 'required',
        ]);
        $user = User::find($request->member_id);
        $store = store::find($user->store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $user->store_id = 0;
                $user->position = 0;
                $user->save();

                $historyApi = new historyApi;
                $des_ar = " تم حذف العميل '$user->email' من المتجر ";
                $des_en = " Customer '$user->email' has been removed from the store ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return 'An employee has been successfully deleted';
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    protected function createPosition($member_id, $store_id, $position)
    {
        $position = new position();
        $position->member_id = $member_id;
        $position->store_id = $store_id;
        $position->position = $position;
        $position->save();
    }

    protected function editPosition($member_id, $store_id, $position)
    {
        $position = new position();
        $position->member_id = $member_id;
        $position->store_id = $store_id;
        $position->position = $position;
        $position->save();
    }

    protected function deletePosition($member_id, $store_id, $position)
    {
        $position = new position();
        $position->member_id = $member_id;
        $position->store_id = $store_id;
        $position->position = $position;
        $position->save();
    }
}
