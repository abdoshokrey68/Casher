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

    public function pdfView($store_id)
    {
        $users = User::get();
        $menu = menu::where('store_id', 2)->first();
        // $path = public_path('image\menu\QR\border2.jpg');
        $store = store::find($store_id);
        // $encodedSVG = \rawurlencode(\str_replace(["\r", "\n"], ' ', \file_get_contents($path)));

        return view('store.menu.qrcode.qrcode', compact('menu', 'store'));
    }

    public function download()
    {
        // ini_set('max_execution_time', -1);
        // ini_set("memory_limit", -1);
        $users = User::get();
        // $store = store::find(2);
        // $menu = menu::where('store_id', 2)->first();
        return $pdf = PDF::loadView('pdf', compact('users'))->stream();
        return $pdf->download('invoice.pdf');
    }
}
