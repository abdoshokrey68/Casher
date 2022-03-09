<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\history;
use App\Models\invoice;
use App\Models\invoicedet;
use App\Models\invoicesett;
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

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_add');

        $invoice_id = $request->invoice_id;
        if ($check) {
            if ($request->invoice_id == '0') {
                return 'empty';
            } else {
                $invoice = invoice::find($invoice_id);
                if ($invoice) {
                    $store = store::find($request->store_id);
                    $invoiceDetails = $this->updateInvoiceTotal($invoice_id);
                    return $invoiceDetails;
                } else {
                    return abort(404);
                }
            }
        } else {
            return abort(401);
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
        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_add');

        if ($check) {
            $product = product::find($request->product_id);
            $store = store::find($product->store_id);
            if ($product) {
                if ($request->invoice_id == 0) {
                    $invoice = $this->createInvoice($store, $request->table_id);
                    $invoice_id =  $invoice->id;
                    if ($request->table_id != 0) {
                        $table = $this->updateTable($request->table_id, $invoice_id);
                    }
                } else {
                    $invoice = invoice::find($request->invoice_id);
                    if ($invoice && !$invoice->paid) {
                        $invoice_id = $request->invoice_id;
                    } else {
                        return abort(401);
                    }
                }
                $details = invoicedet::where('invoice_id', $invoice_id)->where('product_id', $request->product_id)->first();
                if ($details) {
                    $details->quantity = $details->quantity + $request->quantity;
                    $details->save();
                } else {
                    $details = $this->createDetails($product, $request, $store->id, $invoice_id);
                }
                return [
                    'invoice_id'    => $invoice_id,
                    'details'       => $details
                ];
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function deletedetails(Request $request)
    {
        $details_id = $request->invoice_details_id;
        $details = invoicedet::find($details_id);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_add');
        if ($check) {
            $store = store::find($details->store_id);
            if ($details) {
                $invoice = invoice::with('invoicedets')->find($details->invoice_id);
                if (!$invoice->invoicedets) {
                    $invoice->total = 0;
                    $invoice->save();
                }
                $details->delete();
                return "Deleted successfully";
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }

    protected function createInvoice($store, $table_id)
    {
        $invoice_sett = invoicesett::where('store_id', $store->id)->first();
        $invoice = new invoice();
        $invoice->store_id = $store->id;
        $invoice->discount = $store->discount;
        $invoice->table_id = $table_id;
        $invoice->member_id = Auth::id();
        $invoice->tax = $invoice_sett->tax;
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
        $invoiceDetails = invoice::where('id', $invoice_id)->with('invoicedets', 'user')->first();
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

        // $invoiceDetails->f_discount = $invoiceDetails->f_discount + ($invoiceDetails->f_discount * $invoiceDetails->tax / 100);
        // $invoiceDetails->total = $invoiceDetails->total + ($invoiceDetails->total * $invoiceDetails->tax / 100);
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
