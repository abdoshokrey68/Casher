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
            $invoiceTotal = $invoiceTotal + $invoice->f_discount;
        }
        return [
            'invoices' => $invoices,
            'invoicetotal' => $invoiceTotal
        ];
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
            $des_ar = " تم تعديل اعدادات الفواتير الخاصة بالمتجر";
            $des_en = " Store billing settings have been modified";
            $history = $historyApi->createHistory($des_ar, $des_en, $request->store_id, Auth::id());
            return 'done';
        } else {
            return abort(401);
        }
    }

    public function deleteinvoice(Request $request)
    {

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_delete');
        if ($check) {
            $invoice = invoice::find($request->invoice_id);
            $store = store::find($invoice->store_id);
            $historyApi = new historyApi;
            $des_ar = " تم حذف الفاتورة رقم $invoice->id ";
            $des_en = " Invoice No. $invoice->id has been deleted ";
            $history = $historyApi->createHistory($des_ar, $des_en, $store->id, Auth::id());
            $invoice->delete();
            return "Deleted successfully";
        } else {
            return abort(401);
        }
    }

    public function payInvoice(Request $request)
    {
        $this->validate($request, [
            'invoice_id' => 'required|numeric',
            'table_id' => 'required|numeric',
            'paidamount' => 'required|numeric',
        ]);

        $positionApi = new positionApi();
        $check = $positionApi->checkPositionRoute($request->store_id, Auth::id(), 'invoice_add');
        if ($check) {
            $invoice = invoice::find($request->invoice_id);
            $store = store::find($invoice->store_id);
            $table = table::find($request->table_id);
            if ($invoice->store_id == $table->store_id) {
                if ($request->paidamount >= $invoice->f_discount) {
                    $table->status = 0;
                    $table->save();
                    $invoice->paid = $request->f_discount;
                    $invoice->save();
                    return 'Invoice Completed';
                } else {
                    return abort(419);
                }
            } else {
                return abort(419);
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
        $des_ar = " تم استيراد الفواتير ";
        $des_en = " Invoices have been imported ";
        $history = $historyApi->createHistory($des_ar, $des_en, $request->store_id, Auth::id());

        return $request;
        $store_id = Auth::user()->store_id;
        return Excel::download(new InvoiceExport($store_id, $request->getfrom, $request->getto), 'invoices.xlsx');
    }
}
