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
                return position::where('store_id', $request->store_id)->with('getmember')->get();
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
            $store = store::find($request->store_id);
            if ($store) {
                $position = position::where('member_id', $member_id)->where('store_id', $request->store_id)->with('getmember')->first();
                if ($position) {
                    if ($store->manager_id == Auth::id()) {
                        $position->invoice      = explode(',', $position->invoice);
                        $position->section      = explode(',', $position->section);
                        $position->product      = explode(',', $position->product);
                        $position->table      = explode(',', $position->table);
                        $position->member      = explode(',', $position->member);
                        $position->store      = explode(',', $position->store);
                        $position->menu      = explode(',', $position->menu);
                        $position->history      = explode(',', $position->history);
                        $position->box      = explode(',', $position->box);

                        return $position;
                    } else {
                        return 'false1';
                    }
                } else {
                    return 'false2';
                }
            } else {
                return 'false3';
            }
        } else {
            return 'false4';
        }
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email:rfc,dns',
            'position'  => 'required',
            'store_id'  => 'required',
        ]);
        $store_id = $request->store_id;
        $store = store::find($store_id);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    return $this->createPosition($user->id, $store->id, $request);
                    $historyApi = new historyApi;
                    $des_ar = " تم إضافة عميل جديد للمتجر ";
                    $des_en = " A new customer has been added to the store ";
                    $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                    return 'An employee has been added successfully';
                } else {
                    return 'false3';
                }
            } else {
                return abort(422);
            }
        } else {
            return abort(505);
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
        $user = User::find($request->member_id);
        $store = store::find($store_id);
        if ($user) {
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $user = User::where('email', $request->email)->first();
                    $position = $this->editPosition($request->member_id, $request->store_id, $request);
                    $historyApi = new historyApi;
                    $des_ar = " تم تعديل بيانات العميل '$user->email' ";
                    $des_en = " '$user->email' customer data has been modified ";
                    $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                    return $position;
                    return 'An employee has been added successfully';
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

    public function delete(Request $request)
    {
        $this->validate($request, [
            'member_id' => 'required',
            'store_id' => 'required',
        ]);
        $user = User::find($request->member_id);
        $store = store::find($user->store_id);
        if ($user) {
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $this->deletePosition($request->member_id, $request->store_id);
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
        } else {
            return 'false';
        }
    }

    protected function createPosition($member_id, $store_id, $request)
    {
        $old_position = position::where('member_id', $member_id)->where('store_id', $store_id)->first();
        if ($old_position) {
            return abort(404);
        } else {
            $position = new position();
            $position->member_id    = $member_id;
            $position->store_id     = $store_id;
            $position->position         = $request->position;
            if ($request->invoice) {
                $position->invoice      = implode(',', $request->invoice);
            }
            if ($request->section) {
                $position->section      = implode(',', $request->section);
            }
            if ($request->product) {
                $position->product      = implode(',', $request->product);
            }
            if ($request->table) {
                $position->table      = implode(',', $request->table);
            }
            if ($request->member) {
                $position->member      = implode(',', $request->member);
            }
            if ($request->store) {
                $position->store      = implode(',', $request->store);
            }
            if ($request->menu) {
                $position->menu      = implode(',', $request->menu);
            }
            if ($request->history) {
                $position->history      = implode(',', $request->history);
            }
            if ($request->box) {
                $position->box      = implode(',', $request->box);
            }
            $position->save();
        }
    }

    protected function editPosition($member_id, $store_id, $request)
    {
        $position = position::where('member_id', $member_id)->where('store_id', $store_id)->first();
        $position->position = $request->position;
        if ($request->invoice) {
            $position->invoice      = implode(',', $request->invoice);
        }
        if ($request->section) {
            $position->section      = implode(',', $request->section);
        }
        if ($request->product) {
            $position->product      = implode(',', $request->product);
        }
        if ($request->table) {
            $position->table      = implode(',', $request->table);
        }
        if ($request->member) {
            $position->member      = implode(',', $request->member);
        }
        if ($request->store) {
            $position->store      = implode(',', $request->store);
        }
        if ($request->menu) {
            $position->menu      = implode(',', $request->menu);
        }
        if ($request->history) {
            $position->history      = implode(',', $request->history);
        }
        if ($request->box) {
            $position->box      = implode(',', $request->box);
        }
        $position->save();
    }

    protected function deletePosition($member_id, $store_id)
    {
        $position = position::where('member_id', $member_id)->where('store_id', $store_id)->first();
        $position->delete();
    }
}
