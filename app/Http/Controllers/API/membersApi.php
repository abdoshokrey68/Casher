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
        return position::where('store_id', $request->store_id)->with('getmember')->get();
    }

    public function getmember(Request $request)
    {
        $member_id = $request->member_id;
        $user = User::find($member_id);
        if ($user) {
            $store = store::find($request->store_id);
            $position = position::where('member_id', $member_id)->where('store_id', $request->store_id)->with('getmember')->first();
            if ($position) {
                return $position;
            } else {
                return 'false2';
            }
        } else {
            return 'false4';
        }
    }

    public function add(Request $request)
    {

        $this->validate($request, [
            'email'             => 'required|email:rfc,dns',
            'position'          => 'required',
            'store_id'          => 'required',
            'invoice_show'      => 'required',
            'invoice_add'       => 'required',
            'invoice_edit'      => 'required',
            'invoice_delete'    => 'required',
            'section_show'      => 'required',
            'section_add'       => 'required',
            'section_edit'      => 'required',
            'section_delete'    => 'required',
            'member_show'       => 'required',
            'member_add'        => 'required',
            'member_edit'       => 'required',
            'member_delete'     => 'required',
            'product_show'      => 'required',
            'product_add'       => 'required',
            'product_edit'      => 'required',
            'product_delete'    => 'required',
            'table_show'        => 'required',
            'table_add'         => 'required',
            'table_edit'        => 'required',
            'table_delete'      => 'required',
            'history_show'      => 'required',
            'history_delete'    => 'required',
            'menu_edit'         => 'required',
            'store_edit'        => 'required',
            'box_add'           => 'required',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'member_add');

        $store_id = $request->store_id;
        $store = store::find($store_id);
        $user = User::where('email', $request->email)->first();
        if ($check) {
            if ($user) {
                $this->createPosition($user->id, $store->id, $request);
                $historyApi = new historyApi;
                $des_ar = " تم إضافة عميل جديد للمتجر ";
                $des_en = " A new customer has been added to the store ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return 'An employee has been added successfully';
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }
    public function edit(Request $request)
    {
        $this->validate($request, [
            'email'             => 'required|email:rfc,dns',
            'member_id'         => 'required',
            'position'          => 'required',
            'store_id'          => 'required',
            'invoice_show'      => 'required',
            'invoice_add'       => 'required',
            'invoice_edit'      => 'required',
            'invoice_delete'    => 'required',
            'section_show'      => 'required',
            'section_add'       => 'required',
            'section_edit'      => 'required',
            'section_delete'    => 'required',
            'member_show'       => 'required',
            'member_add'        => 'required',
            'member_edit'       => 'required',
            'member_delete'     => 'required',
            'product_show'      => 'required',
            'product_add'       => 'required',
            'product_edit'      => 'required',
            'product_delete'    => 'required',
            'table_show'        => 'required',
            'table_add'         => 'required',
            'table_edit'        => 'required',
            'table_delete'      => 'required',
            'history_show'      => 'required',
            'history_delete'    => 'required',
            'menu_edit'         => 'required',
            'store_edit'        => 'required',
            'box_add'           => 'required',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'member_edit');
        $store = store::find($request->store_id);
        $user = User::where('email', $request->email)->first();
        if ($check) {
            if ($user) {
                $position = position::where('member_id', $user->id)->where('store_id', $store->id)->first();
                if ($position) {
                    $this->editPosition($position, $user->id, $request->store_id, $request);
                    $historyApi = new historyApi;
                    $des_ar = " تم تعديل بيانات العميل '$user->email' ";
                    $des_en = " '$user->email' customer data has been modified ";
                    $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                    return 'An employee has been added successfully';
                } else {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'member_id' => 'required',
            'store_id' => 'required',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'member_delete');

        $user = User::find($request->member_id);
        $store = store::find($user->store_id);
        if ($check) {
            if ($user) {
                $this->deletePosition($request->member_id, $request->store_id);
                $historyApi = new historyApi;
                $des_ar = " تم حذف العميل '$user->email' من المتجر ";
                $des_en = " Customer '$user->email' has been removed from the store ";
                $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return 'An employee has been successfully deleted';
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function position(Request $request)
    {
        $this->validate($request, [
            'store_id'      => 'required'
        ]);
        $store = store::find($request->store_id);
        $position = position::where('store_id', $store->id)->where('member_id', Auth::id())->first();
        return [
            'position'  => $position
        ];
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

            $position->invoice_show     = $request->invoice_show;
            $position->invoice_add  = $request->invoice_add;
            $position->invoice_edit     = $request->invoice_edit;
            $position->invoice_delete   = $request->invoice_delete;
            $position->section_show     = $request->section_show;
            $position->section_add  = $request->section_add;
            $position->section_edit     = $request->section_edit;
            $position->section_delete   = $request->section_delete;
            $position->member_show  = $request->member_show;
            $position->member_add   = $request->member_add;
            $position->member_edit  = $request->member_edit;
            $position->member_delete    = $request->member_delete;
            $position->product_show     = $request->product_show;
            $position->product_add  = $request->product_add;
            $position->product_edit     = $request->product_edit;
            $position->product_delete   = $request->product_delete;
            $position->table_show   = $request->table_show;
            $position->table_add    = $request->table_add;
            $position->table_edit   = $request->table_edit;
            $position->table_delete     = $request->table_delete;
            $position->history_show     = $request->history_show;
            $position->history_delete   = $request->history_delete;
            $position->menu_edit    = $request->menu_edit;
            $position->store_edit   = $request->store_edit;
            $position->box_add  = $request->box_add;
            $position->save();
        }
    }

    protected function editPosition($position, $member_id, $store_id, $request)
    {
        $position->member_id        = $member_id;
        $position->position         = $request->position;
        $position->invoice_show     = $request->invoice_show;
        $position->invoice_add      = $request->invoice_add;
        $position->invoice_edit     = $request->invoice_edit;
        $position->invoice_delete   = $request->invoice_delete;
        $position->section_show     = $request->section_show;
        $position->section_add      = $request->section_add;
        $position->section_edit     = $request->section_edit;
        $position->section_delete   = $request->section_delete;
        $position->member_show      = $request->member_show;
        $position->member_add       = $request->member_add;
        $position->member_edit      = $request->member_edit;
        $position->member_delete    = $request->member_delete;
        $position->product_show     = $request->product_show;
        $position->product_add      = $request->product_add;
        $position->product_edit     = $request->product_edit;
        $position->product_delete   = $request->product_delete;
        $position->table_show       = $request->table_show;
        $position->table_add        = $request->table_add;
        $position->table_edit       = $request->table_edit;
        $position->table_delete     = $request->table_delete;
        $position->history_show     = $request->history_show;
        $position->history_delete   = $request->history_delete;
        $position->menu_edit        = $request->menu_edit;
        $position->store_edit       = $request->store_edit;
        $position->box_add          = $request->box_add;
        $position->save();
    }

    protected function deletePosition($member_id, $store_id)
    {
        $position = position::where('member_id', $member_id)->where('store_id', $store_id)->first();
        $position->delete();
    }
}
