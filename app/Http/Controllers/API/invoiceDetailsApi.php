<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\history;
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
            'invoice_id' => 'required|numeric',
            'store_id' => 'required'
        ]);
        $invoice_id = $request->invoice_id;
        if ($request->invoice_id == '0') {
            return 'empty';
        } else {
            $invoice = invoice::find($invoice_id);
            if ($invoice) {
                $store = store::find($invoice->store_id);
                if ($store) {
                    $invoiceDetails = $this->updateInvoiceTotal($invoice_id);
                    return $invoiceDetails;
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
                if ($request->invoice_id == 0) {
                    // return $store;
                    $invoice = $this->createInvoice($store, $request->table_id);
                    $invoice_id =  $invoice->id;
                    if ($request->table_id != 0) {
                        $table = $this->updateTable($request->table_id, $invoice_id);
                    } else {
                        $table = "";
                    }
                } else {
                    $invoice = invoice::find($request->invoice_id);
                    if ($invoice) {
                        $invoice_id = $request->invoice_id;
                    } else {
                        return 'false2';
                    }
                }
                $details = invoicedet::where('invoice_id', $invoice_id)->where('product_id', $request->product_id)->first();
                if ($details) {
                    $details->quantity = $details->quantity + $request->quantity;
                    $details->save();
                    return $details;
                } else {

                    return $details = $this->createDetails($product, $request, $store->id, $invoice_id);

                    return [
                        'invoice_id'    => $invoice_id,
                        'table'         => $table,
                        'details'       => $details
                    ];
                    // return 'Item has been added successfully';
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
                $invoice = invoice::with('invoicedets')->find($details->invoice_id);
                if (!$invoice->invoicedets) {
                    $invoice->total = 0;
                    $invoice->save();
                }
                $details->delete();
                // $details->save();
                return "Deleted successfully";
            } else {
                return 'false2';
            }
        } else {
            return 'false3';
        }
    }

    protected function createInvoice($store, $table_id)
    {
        $invoice = new invoice();
        $invoice->create_id = date('ymd');
        $invoice->store_id = $store->id;
        $invoice->discount = $store->discount;
        $invoice->table_id = $table_id;
        $invoice->member_id = Auth::id();
        $invoice->save();
        return $invoice;
    }

    protected function updateTable($table_id, $invoice_id)
    {
        $table = table::find($table_id);
        $table->status = $invoice_id;
        $table->save();
        return $table;
    }

    protected function updateInvoiceTotal($invoice_id)
    {
        $invoiceDetails = invoice::where('id', $invoice_id)->with('invoicedets')->first();
        $invoiceDetails->f_discount = 0;
        $invoiceDetails->total = 0;
        if ($invoiceDetails->discount != 0) {
            foreach ($invoiceDetails->invoicedets as $details) {
                $invoiceDetails->total = $invoiceDetails->total + ($details->price  * $details->quantity);
                $invoiceDetails->f_discount = $invoiceDetails->f_discount + ($details->price * $details->quantity - (($details->price * ($invoiceDetails->discount / 100)) * $details->quantity));
            }
        } else {
            foreach ($invoiceDetails->invoicedets as $details) {
                $invoiceDetails->total = ($invoiceDetails->total + ($details->price  * $details->quantity));
                $invoiceDetails->f_discount = ($invoiceDetails->f_discount + ($details->price  * $details->quantity));
            }
        }
        $invoiceDetails->save();
        return $invoiceDetails;
    }

    protected function createDetails($product, $request, $store_id, $invoice_id)
    {
        $details = new invoicedet();
        $details->name = $product->name;
        $details->product_id = $request->product_id;
        $details->price =  $product->price;
        $details->quantity = $request->quantity;
        $details->invoice_id = $invoice_id;
        $details->store_id = $store_id;
        $details->save();
        return $details;
    }
}
