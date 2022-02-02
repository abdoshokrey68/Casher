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

class sectionApi extends Controller
{
    public function sectiondet(Request $request)
    {
        $store_id = $request->store_id;
        $section_id = $request->section_id;
        $store = store::find($store_id);
        if ($store->manager_id == Auth::id()) {
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
            if ($store->manager_id == Auth::id()) {
                return section::where('store_id', $store_id)->get();
            } else {
                return 'false';
            }
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
                if ($store->manager_id == Auth::id()) {
                    return $section;
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

    public function createnewsection(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'store_id' => 'required|integer',
            'description' => 'max:255',
            'discount' => 'required|integer',
        ]);

        $store = store::find($request->store_id);
        if ($store->manager_id == Auth::id()) {
            $section = new section();
            $section->name = $request->name;
            $section->description = $request->description;
            $section->discount = $request->discount;
            $section->store_id = $request->store_id;
            $section->save();
            return "Added successfully";
        } else {
            return 'false';
        }
    }

    public function updatesection(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'store_id' => 'required|integer',
            'section_id' => 'required|integer',
            'description' => 'max:255',
            'discount' => 'required|integer',
        ]);

        $store = store::find($request->store_id);
        if ($store->manager_id == Auth::id()) {
            $section = section::find($request->section_id);
            if ($section) {
                $section->name = $request->name;
                $section->description = $request->description;
                $section->discount = $request->discount;
                $section->save();
                return "Updated successfully";
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function deletesection(Request $request)
    {
        $section_id = $request->section_id;
        $section = section::find($section_id);
        if ($section) {
            $store = store::find($section->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $section->delete();
                    return "Deleted successfully";
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
}
