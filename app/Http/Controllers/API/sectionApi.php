<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\invoice;
use App\Models\invoicedet;
use App\Models\product;
use App\Models\section;
use App\Models\store;
use App\Models\table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class sectionApi extends Controller
{
    public function sectiondet(Request $request)
    {
        $store_id = $request->store_id;
        $section_id = $request->section_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store_id && $section_id && $section_id != 0) {
                return section::where('store_id', $store_id)->where('id', $section_id)->with('products')->first();
            } elseif ($store_id && $section_id == 0) {
                return product::where('store_id', $store_id)->where('stock', '!=', 0)->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function getsections(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            return section::where('store_id', $store_id)->get();
        } else {
            return 'false';
        }
    }

    public function getsection(Request $request)
    {
        $section_id = $request->section_id;
        $section = section::find($section_id);
        if ($section) {
            $store = store::find($section->store_id);
            if ($store) {
                return $section;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function createnewsection(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:255',
            'store_id'      => 'required|integer',
            'description'   => 'max:255',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'section_add');

        $sectionIcon = null;
        $store = store::find($request->store_id);
        if ($check) {
            $section = new section();
            $section->name = $request->name;
            $section->description = $request->description;
            $section->store_id = $request->store_id;
            $sectionIcon = null;
            if ($request->icon) {
                $this->validate($request, [
                    'icon'          => 'required|max:30',
                ]);
                $sectionIcon = $request->icon;
            }
            $section->icon = $sectionIcon;
            $section->save();

            $historyApi = new historyApi;
            $des_ar = " ???? ?????????? ?????? ???????? ????????  '$section->name'  ";
            $des_en = " A new section has been created called '$section->name' ";
            $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
            return "Added successfully";
        } else {
            return abort(401);
        }
    }



    public function updatesection(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'store_id' => 'required|integer',
            'section_id' => 'required|integer',
            'description' => 'max:255',
        ]);
        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'section_edit');

        $store = store::find($request->store_id);
        if ($check) {
            $section = section::find($request->section_id);
            if ($section) {
                $section->name = $request->name;
                $section->description = $request->description;
                if ($request->icon) {
                    $this->validate($request, [
                        'icon'          => 'required|max:30',
                    ]);
                    $sectionIcon = $request->icon;
                    $section->icon = $sectionIcon;
                }
                $section->save();

                $historyApi = new historyApi;
                $des_ar = " ???? ?????????? ?????????? ' $section->name ' ";
                $des_en = " Section '$section->name' has been modified ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return "Updated successfully";
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function deletesection(Request $request)
    {
        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'section_delete');

        $section_id = $request->section_id;
        $section = section::find($section_id);
        if ($check) {
            $store = store::find($section->store_id);
            if ($section) {
                $setion_old_name = $section->name;
                $section->delete();
                $historyApi = new historyApi;
                $des_ar = " ???? ?????? ?????????? '$setion_old_name'";
                $des_en = " Section '$setion_old_name' has been removed ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return "Deleted successfully";
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }
}
