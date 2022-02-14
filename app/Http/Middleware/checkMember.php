<?php

namespace App\Http\Middleware;

use App\Models\position;
use App\Models\store;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkMember
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
        $user = Auth::user();
        if ($user) {
            $store_id = $request->store_id;
            $store = store::find($store_id);
            if ($store) {
                $position = position::where('store_id', $store_id)->where('member_id', $user->id)->first();
                if ($position) {
                    return $next($request);
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }
}
