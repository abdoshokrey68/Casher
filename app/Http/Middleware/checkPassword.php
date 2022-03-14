<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkPassword
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
        if ($request->api_password !== env("API_PASSWORD", "Z79smu8C9gf6SFRjzCijJMON5dSDpo7Mckfig9SaPXDO")) {
            return response()->json(['message' => "Unauthenticated"]);
        } else {
            return $next($request);
        }
    }
}
