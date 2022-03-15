<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\menu;
use App\Models\store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class menuApi extends Controller
{
    public function index(Request $request)
    {
        return $request;
        $this->validate($request, [
            'store_id'  => 'required'
        ]);
        $store = store::find($request->store_id);
        if ($store) {
            $menu = menu::where('store_id', $store->id)->first();
            return $menu;
        } else {
            return 'fasle';
        }
        return 'done';
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'store_id'      => 'required',
            // 'design_no'     => 'required',
            'background_co' => 'required',
            'text_co'       => 'required',
            'heading_co'    => 'required',
            'des_co'        => 'required',
            'icon_co'       => 'required',
            'price_co'      => 'required',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'menu_edit');

        $store = store::find($request->store_id);
        if ($check) {
            $menu = menu::where('store_id', $store->id)->first();
            if ($menu) {
                $menu->design_no = $request->design_no;
                $menu->background_co = $request->background_co;
                $menu->text_co = $request->text_co;
                $menu->heading_co = $request->heading_co;
                $menu->des_co = $request->des_co;
                $menu->icon_co = $request->icon_co;
                $menu->price_co = $request->price_co;
                $historyApi = new historyApi;
                $des_ar = " تم تعديل منيو المتجر ";
                $des_en = " Store menu has been modified ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                $menu->save();
                return $menu;
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }
}
