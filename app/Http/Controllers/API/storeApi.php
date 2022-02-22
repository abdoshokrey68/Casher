<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\audience;
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
use Illuminate\Support\Facades\Hash;

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
            "audience"      =>  "required",
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
                if ($request->audience == false) {
                    $store->audience = 0;
                } else {
                    $store->audience = 1;
                }
                if ($request->password) {
                    $request->validate([
                        'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
                    ]);
                    $store->password = Hash::make($request->password);
                }
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


                $historyApi = new historyApi;
                $des_ar = " تم تعديل بيانات المتجر ";
                $des_en = " Store information has been modified ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());

                $store->save();
                return $store;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function addNewStore(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:120',
            'email'     => 'required|email:rfc,dns',
            'phone'     => 'required',
            'location'  => 'required',
            'currency'  => 'required|min:3|max:3',
        ]);
        // $request->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));

        $store = new store();
        // $store = store::create([$request->all()]);
        $store->name = $request->name;
        $store->email = $request->email;
        $store->phone = $request->phone;
        $store->location = $request->location;
        $store->currency = $request->currency;
        $store->manager_id = 2; // Will Delete Soon
        $store->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $store->save();
        $value = $this->createPosition($store->id, Auth::id());

        $historyApi = new historyApi;
        $des_ar = " تم إنشاء المتجر نتمني لك كل التوفيق ";
        $des_en = " The store has been created, we wish you all the best ";
        $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
        return [
            'storeName' => $store->name,
            'route'     => route('store', $store->id),
        ];
    }

    protected function createPosition($store_id, $user_id)
    {
        $position = new position();
        $position->poristion = 0;
        $position->store_id = $store_id;
        $position->member_id = $user_id;
        $position->save();
        return $position;
    }
}
