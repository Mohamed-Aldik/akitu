<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminChatWithAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->user()->utype === "SADM" || auth()->user()->utype === "ADM") 
        {
            return $next($request);
        } else {
            abort(404);
        }
        return $next($request);
    }
}
