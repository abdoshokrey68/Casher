<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\section;
use App\Models\store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // check if he has store
        $user_id = Auth::id();
        $store = store::where('manager_id', $user_id)->first();
        if ($store) {
            return redirect()->route('store', $store->id);
        } else {
            return view('home');
        }
    }

    public function store($store_id)
    {
        $store = store::where('id', $store_id)->first();
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return view('store.dashboard.index', compact('store_id'));
            } else {
                return view('home');
            }
        } else {
            return 'false';
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
}
