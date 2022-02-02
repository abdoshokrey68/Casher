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

class invoiceDetailsApi extends Controller
{
    public function invoicedetails(Request $request)
    {
        $this->validate($request, [
            'invoice_id' => 'required|numeric'
        ]);
        $invoice_id = $request->invoice_id;
        if ($request->invoice_id == '0') {
            return 'empty';
        } else {
            $invoice = invoice::find($invoice_id);
            return $request;
            if ($invoice) {
                $store = store::find($invoice->store_id);
                if ($store) {
                    if ($store->manager_id == Auth::id()) {
                        $invoiceDetails = invoice::where('id', $invoice_id)->with('invoicedets')->first();
                        $invoiceTotal = 0;
                        foreach ($invoiceDetails->invoicedets as $details) {
                            $invoiceTotal = $invoiceTotal + (($details->price - ($details->price * ($details->discount / 100))) * $details->quantity);
                        }
                        $invoiceDetails->invoiceTotal = $invoiceTotal;
                        return $invoiceDetails;
                    } else {
                        return 'false1';
                    }
                } else {
                    return 'false2';
                }
            } else {
                return 'false3';
            }
        }
    }

    public function addtodetails(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required|numeric|min:0|not_in:0',
            'invoice_id' => 'required|numeric',
            'table_id' => 'required|numeric',
            'product_id' => 'required|numeric',
        ]);
        $product = product::find($request->product_id);
        if ($product) {
            $store = store::find($product->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    if ($request->invoice_id == 0) {
                        $invoice = new invoice();
                        $invoice->create_id = date('ymd');
                        $invoice->store_id = $store->id;
                        $invoice->discount = $store->discount;
                        $invoice->table_id = $request->table_id;
                        return $request;
                        $invoice->save();
                        return $invoice;
                    } else {
                        $invoice = invoice::find($request->invoice_id);
                        if ($invoice) {
                        } else {
                            return 'false2';
                        }
                    }
                    $details = invoicedet::where('invoice_id', $request->invoice_id)->where('product_id', $request->product_id)->first();
                    if ($details) {
                        $details->quantity = $details->quantity + $request->quantity;
                        $details->save();
                        return $details;;
                    } else {
                        $details = new invoicedet();
                        $details->name = $product->name;
                        $details->product_id = $request->product_id;
                        $details->price =  $product->price;
                        $details->quantity = $request->quantity;
                        $details->discount = $invoice->discount;
                        $details->invoice_id = $request->invoice_id;
                        $details->store_id = $store->id;
                        $details->save();
                        return 'Item has been added successfully';
                    }
                } else {
                    return 'false3';
                }
            } else {
                return 'false3';
            }
        } else {
            return 'false1';
        }
    }

    public function deletedetails(Request $request)
    {
        $details_id = $request->invoice_details_id;
        $details = invoicedet::find($details_id);
        if ($details) {
            $store = store::find($details->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $invoice = invoice::with('invoicedets')->find($details->invoice_id);
                    if (!$invoice->invoicedets) {
                        $invoice->total = 0;
                        $invoice->save();
                    }
                    $details->delete();
                    // $details->save();
                    return "Deleted successfully";
                } else {
                    return 'false1';
                }
            } else {
                return 'false2';
            }
        } else {
            return 'false3';
        }
    }
}
