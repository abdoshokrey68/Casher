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

class tableApi extends Controller
{
    public function gettables(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return table::where('store_id', $store_id)->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function gettable(Request $request)
    {
        $table_id = $request->table_id;
        $table = table::find($table_id);
        if ($table) {
            $store = store::find($table->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    return $table;
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

    public function addtable(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'store_id'  => 'required|integer',
        ]);
        $table_id = $request->table_id;
        // return 'test1';
        $store = store::find($request->store_id);
        if ($store) {
            // return 'test2';
            if ($store->manager_id == Auth::id()) {
                // return 'test3';
                $table = new table();
                $table->name = $request->name;
                $table->store_id = $request->store_id;
                $table->status = 0;
                $table->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
                $table->save();
                return "Added successfully";
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function updatetable(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'table_id'  => 'required',
            'store_id'  => 'required',
        ]);

        $table_id = $request->table_id;
        $table = table::find($table_id);
        if ($table) {
            $store = store::find($table->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $table->name = $request->name;
                    $table->save();
                    return "Edited successfully";
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

    public function deletetable(Request $request)
    {
        $table_id = $request->table_id;
        $table = table::find($table_id);
        if ($table) {
            $store = store::find($table->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $table->delete();
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
