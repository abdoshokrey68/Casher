<?php

namespace App\Http\Controllers;

use App\Models\history;
use App\Models\store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class historyApi extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'store_id'     => 'required',
            'locale'     => 'required'
        ]);
        $store = store::find($request->store_id);
        if ($store) {
            if ($store->member_id = Auth::id()) {
                $locale = app()->getLocale();
                $histories = history::where('store_id', $request->store_id)->select("des_$request->locale as des", "member_id", "created_at")->with('member')->get();
                foreach ($histories as $key => $history) {
                    $history->from = $history->created_at->diffForHumans();
                }
                return $histories;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function createHistory($des_ar, $des_en, $store_id = 2, $member_id)
    {
        // validator([])
        $history = new history();
        $history->des_ar = $des_ar;
        $history->des_en = $des_en;
        $history->store_id = $store_id;
        $history->member_id = $member_id;
        $history->save();
        return $history;
    }
}
