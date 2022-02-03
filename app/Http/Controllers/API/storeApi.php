<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\invoice;
use App\Models\invoicedet;
use App\Models\product;
use App\Models\section;
use App\Models\store;
use App\Models\table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeApi extends Controller
{

    public function store_d(Request $request)
    {
        $store_id = $request->store_id;
        $this->validate($request, [
            'store_id'  => 'required|integer'
        ]);
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return store::with('sections', 'sections.products')->find($store_id);
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function storeinfo(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return store::find($store_id);
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function updateinfo(Request $request)
    {

        $this->validate($request, [
            "name"          =>  "required|max:100",
            "description"   =>  "max:255",
            "location"      =>  "required|max:200",
            "phone"         =>  "required",
            "email"         =>  "required|email:rfc,dns",
            "currency"      =>  "required|max:4",
            "manager_id"    =>  "required|integer",
            "store_id"      =>  "required|integer",
            "discount"      =>  "required|integer",
        ]);
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $store->name = $request->name;
                $store->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
                $store->description = $request->description;
                $store->location = $request->location;
                $store->phone = $request->phone;
                $store->email = $request->email;
                $store->currency = $request->currency;
                $store->discount = $request->discount;
                $store->manager_id = $request->manager_id;
                if ($request->image) {
                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ]);
                    $imageName = time() . rand(1, 9000) . '.' . $request->image->extension();
                    $request->image->move(public_path('/image/stores/image'), $imageName);
                    if (file_exists(public_path("/image/stores/image/$store->image"))) {
                        unlink(public_path("/image/stores/image/$store->image"));
                    }
                    $store->image = $imageName;
                }
                if ($request->cover) {
                    $request->validate([
                        'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ]);
                    $coverName = time() . rand(1, 9000) . '.' . $request->cover->extension();
                    $request->cover->move(public_path('/image/stores/cover'), $coverName);
                    if (file_exists(public_path("/image/stores/cover/$store->cover"))) {
                        unlink(public_path("/image/stores/cover/$store->cover"));
                    }
                    $store->cover = $coverName;
                }
                $store->save();
                return 'The data has been modified successfully';
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }
}
