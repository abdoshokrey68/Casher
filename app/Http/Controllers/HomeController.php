<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\section;
use App\Models\store;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
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
        return view('pdf', compact('users'));
    }
    public function download($store_id)
    {
        return view('pdf');
    }
}
