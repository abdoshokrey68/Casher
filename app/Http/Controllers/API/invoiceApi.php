<?php

namespace App\Http\Controllers\api;

use App\Exports\InvoiceExport;
use App\Http\Controllers\Controller;
use App\Models\invoice;
use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class invoiceApi extends Controller
{
    public function dailyinvoice(Request $request)
    {
        $store_id = $request->store_id;
        $this->validate($request, [
            'getto' => 'required',
            'getfrom' => 'required',
            'store_id' => 'required|integer',
        ]);
        // $getToDate = date('Y-m-d', Time() - (60 * 60 * 24 * $request->getto));
        // $getfromdate = date('Y-m-d', Time() - (60 * 60 * 24 * $request->getfrom));
        $store = store::find($store_id);

        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $invoices = invoice::where('store_id', $store_id)->where('created_at', '>=', $request->getfrom)->where('created_at', '<=', $request->getto)->with('invoicedets')->orderby('created_at', 'DESC')->get();
                $invoiceTotal = 0;
                foreach ($invoices as $invoice) {
                    $invoice->date = $invoice->created_at->diffForHumans();
                    if ($invoice->discount && $invoice->discount < 0)
                        $invoiceTotal = $invoiceTotal + ($invoice->total - ($invoice->total * ($invoice->discount / 100)));
                    else
                        $invoiceTotal =  $invoiceTotal + $invoice->total;
                }
                return [
                    'invoices' => $invoices,
                    'invoicetotal' => $invoiceTotal
                ];
            } else {
                return 'false';
            }
        } else {

            return 'false';
        }
    }

    public function deleteinvoice(Request $request)
    {
        $invoice = invoice::find($request->invoice_id);
        $store = store::find($invoice->store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $invoice->delete();
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
        $this->validate($request, [
            'getto' => 'required',
            'getfrom' => 'required',
            'store_id' => 'required|integer',
        ]);
        $store_id = Auth::user()->store_id;
        return Excel::download(new InvoiceExport($store_id, $request->getfrom, $request->getto), 'invoices.xlsx');
    }
}
