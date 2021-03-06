<?php

namespace App\Http\Controllers\api;

use App\Exports\InvoiceExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\historyApi;
use App\Models\invoice;
use App\Models\invoicesett;
use App\Models\store;
use App\Models\table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class invoiceApi extends Controller
{
    public function dailyinvoice(Request $request)
    {
        $this->validate($request, [
            'getto' => 'required',
            'getfrom' => 'required',
            'store_id' => 'required|integer',
        ]);
        $store_id = $request->store_id;
        $store = store::find($request->store_id);
        $invoices = invoice::where('store_id', $store_id)->where('paid', '!=', NULL)->where('created_at', '>=', $request->getfrom)->where('created_at', '<=', $request->getto)->with('invoicedets')->orderby('created_at', 'DESC')->get();
        $invoiceTotal = 0;
        foreach ($invoices as $invoice) {
            $invoice->date = $invoice->created_at->diffForHumans();
            $invoiceTotal = $invoiceTotal + ($invoice->total - ($invoice->total * ($invoice->discount / 100)) + ($invoice->total * ($invoice->tax / 100)));
        }

        return [
            'invoices' => $invoices,
            'invoicetotal' => $invoiceTotal
        ];
    }

    public function notpaid(Request $request)
    {
        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_add');
        if ($check) {
            $store_id = $request->store_id;
            $store = store::find($request->store_id);
            $invoices = invoice::where('store_id', $store_id)->where('table_id', 0)->where('paid', NULL)->get();
            return $invoices;
        } else {
            return abort(401);
        }
    }

    public function allnotpaid(Request $request)
    {
        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'box_add');
        if ($check) {
            $store_id = $request->store_id;
            $store = store::find($request->store_id);
            $invoices = invoice::where('store_id', $store_id)->where('paid', NULL)->get();
            if ($invoices)
                return $invoices;
        } else {
            return abort(401);
        }
    }
    public function settings(Request $request)
    {
        $this->validate($request, [
            'store_id'      => 'required'
        ]);
        if ($request->locale) {
            $invoice_s = invoicesett::where('store_id', $request->store_id)->select('tax', 'product_rtn', "message_$request->locale as message")->first();
        } else {
            $invoice_s = invoicesett::where('store_id', $request->store_id)->first();
        }
        return $invoice_s;
    }

    public function settingsEdit(Request $request)
    {
        $this->validate($request, [
            'store_id'      => 'required'
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_edit');
        if ($check) {
            $invoice_s = invoicesett::where('store_id', $request->store_id)->first();
            $invoice_s->tax = $request->tax;
            $invoice_s->autotax     = $request->autotax;
            $invoice_s->tax_record  = $request->tax_record;
            $invoice_s->tax_card    = $request->tax_card;
            $invoice_s->file_no     = $request->file_no;
            $invoice_s->product_rtn = $request->product_rtn;
            $invoice_s->message_en = $request->message_en;
            $invoice_s->message_ar = $request->message_ar;
            $invoice_s->save();

            $historyApi = new historyApi;
            $des_ar = " ???? ?????????? ?????????????? ???????????????? ???????????? ??????????????";
            $des_en = " Store billing settings have been modified";
            $history = $historyApi->createHistory($des_ar, $des_en, $request->store_id, Auth::id());
            return 'done';
        } else {
            return abort(401);
        }
    }

    public function deleteinvoice(Request $request)
    {
        // $this->validate($request, [
        //     "password"  => "required"
        // ]);
        // $user = Auth::user();
        // if (Hash::check($request->password, $user->password)) {
        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_delete');
        if ($check) {
            $invoice = invoice::find($request->invoice_id);
            if ($invoice) {
                if ($request->table_id) {
                    if (!$invoice->paid) {
                        if ($request->table_id != 0) {
                            $table = table::find($request->table_id);
                            if ($table) {
                                // this Statment to check when the invoice deleted is paid or not
                                $table->status = 0;
                                $table->save();
                            } else {
                                return abort(404);
                            }
                        }
                    } else {
                        return abort(404);
                    }
                }
                $store = store::find($invoice->store_id);
                $historyApi = new historyApi;
                $des_ar = " ???? ?????? ???????????????? ?????? $invoice->id ";
                $des_en = " Invoice No. $invoice->id has been deleted ";
                $invoice->delete();
                $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
                return "Deleted successfully";
            } else {
                return abort(404);
            }
        } else {
            return abort(401);
        }
        // } else {
        //     return abort(401);
        // }
    }

    public function payInvoice(Request $request)
    {
        $this->validate($request, [
            'invoice_id' => 'required|numeric',
            'table_id' => 'required|numeric',
            'paidamount' => 'required|numeric',
            'store_id' => 'required',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_add');
        if ($check) {
            $invoice = invoice::find($request->invoice_id);
            if ($invoice) {
                $store = store::find($invoice->store_id);
                $total = $invoice->total - ($invoice->total * ($invoice->discount / 100)) + ($invoice->total * ($invoice->tax / 100));
                if ($request->table_id != 0) {
                    $table = table::find($request->table_id);
                    if ($invoice->store_id == $table->store_id) {
                        if ($request->paidamount >= $total) {
                            $table->status = 0;
                            $table->save();
                            $invoice->paid = $total;
                            return $invoice->save();
                        } else {
                            return abort(419);
                        }
                    } else {
                        return abort(419);
                    }
                } else {
                    if ($request->paidamount >= $invoice->f_discount) {
                        $invoice->paid = $total;
                        return $invoice->save();
                    } else {
                        return abort(419);
                    }
                }
            } else {
                return abort(401);
            }
        } else {
            return abort(401);
        }
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'getto' => 'required',
            'getfrom' => 'required',
            'store_id' => 'required|integer',
        ]);
        $historyApi = new historyApi;
        $des_ar = " ???? ?????????????? ???????????????? ";
        $des_en = " Invoices have been imported ";
        $history = $historyApi->createHistory($des_ar, $des_en, $request->store_id, Auth::id());

        return $request;
        $store_id = Auth::user()->store_id;
        return Excel::download(new InvoiceExport($store_id, $request->getfrom, $request->getto), 'invoices.xlsx');
    }
}
