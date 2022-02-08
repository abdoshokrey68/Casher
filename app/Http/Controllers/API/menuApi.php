<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\menu;
use App\Models\store;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class menuApi extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'store_id'  => 'required'
        ]);
        $store = store::find($request->store_id);
        if ($store) {
            $menu = menu::where('store_id', $store->id)->first();
            if (!$menu) {
                $menu = $this->createMenu($store->id);
            }
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
        $store = store::find($request->store_id);
        if ($store) {
            $menu = menu::where('store_id', $store->id)->first();
            if ($menu) {
                $menu->design_no = $request->design_no;
                $menu->background_co = $request->background_co;
                $menu->text_co = $request->text_co;
                $menu->heading_co = $request->heading_co;
                $menu->des_co = $request->des_co;
                $menu->icon_co = $request->icon_co;
                $menu->price_co = $request->price_co;
                $menu->save();
                return $menu;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    // ================================================================
    // ===================== Protected Functions ======================
    // ================================================================
    protected function createMenu($store_id)
    {
        $qrcodeName = $this->CreateMenuQr($store_id);
        $menu = new menu();
        $menu->store_id = $store_id;
        $menu->qrcode_name = $qrcodeName;
        $menu->save();
        return $menu;
    }

    protected function CreateMenuQr($store_id)
    {
        $url = route('store.menu', $store_id);
        $qrcode = QrCode::size(300)->generate($url);
        $qrcodeName = Time() . rand(1, 500) . '-' . $store_id . '.svg';
        file_put_contents("image/menu/QR/$qrcodeName", $qrcode);
        return $qrcodeName;
    }
}
