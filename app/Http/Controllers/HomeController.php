<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\menu;
use App\Models\section;
use App\Models\store;
use App\Models\User;
// use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function error()
    {
        return view('errors.illustrated-layout');
    }

    public function casherProgram()
    {
        return view('home.casher');
    }

    public function createStore()
    {
        return view('createstore');
    }

    public function store($store_id)
    {
        $store = store::find($store_id);
        if ($store) {
            return view('store.dashboard.index', compact('store_id'));
        } else {
            return redirect()->route('home');
        }
    }

    public function menu($store_id)
    {
        $store = store::where('id', $store_id)->first();
        if ($store) {
            return view('store.menu.index', compact('store_id'));
        } else {
            return 'false';
        }
    }

    public function printInvoice($store_id, $invoice_id)
    {
        $store = store::find($store_id);
        $invoice = invoice::find($invoice_id);
        if ($store && $invoice) {
            if ($invoice->paid)
                return view('store.dashboard.printinvoice', compact('store_id', 'invoice_id'),);
            else
                return abort(401);
        } else {
            return abort(404);
        }
    }
}
