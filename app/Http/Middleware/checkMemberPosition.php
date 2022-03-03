<?php

namespace App\Http\Middleware;

use App\Models\position;
use App\Models\store;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkMemberPosition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $member_id = Auth::id();
        $store = store::findOrFail($request->store_id);
        if ($store) {
            $position = position::where('store_id', $store->id)->where('member_id', $member_id)->first();
            return $next($request);
        } else {
            return redirect()->route('error');
        }
    }
}
