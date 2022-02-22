<?php

namespace App\Http\Controllers\api;

use App\Exports\ProductExport;
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
use Maatwebsite\Excel\Facades\Excel;

class productApi extends Controller
{
    public function getproducts(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return product::where('store_id', $store_id)->with('section')->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function getproduct(Request $request)
    {
        $product = product::find($request->edit_product_id);
        if ($product) {
            $store = store::find($product->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    return $product;
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

    public function productdetails(Request $request)
    {
        $product_id = $request->product_id;
        $product = product::find($product_id);
        if ($product) {
            $store = store::find($product->store_id);
            if ($store->manager_id == Auth::id()) {
                return $product;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function addnewproduct(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'price' => 'required',
            'stock' => 'required|integer',
            'section_id' => 'required',
            'store_id' => 'required',
        ]);
        $imageName = null;
        if ($request->image) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
            $imageName = time() . rand(1, 9000) . '.' . $request->image->extension();
            $request->image->move(public_path('/image/products'), $imageName);
        }
        $store = store::find($request->store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $product = product::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'section_id' => $request->section_id,
                    'store_id' => $request->store_id,
                    'image'     => $imageName,
                ]);

                $historyApi = new historyApi;
                $des_ar = " تمت إضافة عنصر يسمى '$product->name' ";
                $des_en = " An item called ' $product->name ' has been added. ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());

                return "Added successfully";
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function updateproduct(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'price' => 'required',
            'stock' => 'required|integer',
            'section_id' => 'required|integer',
            'store_id' => 'required',
            'edit_product_id' => 'required'
        ]);
        $imageName = null;
        if ($request->image) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
            $imageName = time() . rand(1, 9000) . '.' . $request->image->extension();
            $request->image->move(public_path('/image/products'), $imageName);
        }
        $product = product::find($request->edit_product_id);
        if ($product) {
            $store = store::find($product->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $product->name          = $request->name;
                    $product->description   = $request->description;
                    $product->price         = $request->price;
                    $product->stock         = $request->stock;
                    $product->section_id    = $request->section_id;
                    $product->store_id      = $request->store_id;
                    $product->image         = $imageName;
                    $product->save();

                    $historyApi = new historyApi;
                    $des_ar = " تمت تعديل العنصر  '$product->name' ";
                    $des_en = " The item '$product->name' has been modified ";
                    $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                    return "Added successfully";
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

    public function deleteproduct(Request $request)
    {
        $product_id = $request->product_id;
        $product = product::find($product_id);
        if ($product) {
            $store = store::find($product->store_id);
            if ($store->manager_id == Auth::id()) {
                $old_product_name = $product->name;
                $product->delete();

                $historyApi = new historyApi;
                $des_ar = " تم حذف العنصر '$old_product_name' ";
                $des_en = " The item '$old_product_name' has been removed. ";
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return "Deleted successfully";
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function export(Request $request)
    {
        $store_id = Auth::user()->store_id;
        return Excel::download(new ProductExport($store_id), 'product.xlsx');
    }
}
