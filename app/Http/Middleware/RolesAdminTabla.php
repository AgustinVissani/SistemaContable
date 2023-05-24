<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesAdminTabla
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
        if ( (Auth::check() && Auth::user()->id_rol == 3) || (Auth::check() && Auth::user()->id_rol == 1) ) {
            return $next($request);
        } else {
            return redirect('/');
        }

    }
}
