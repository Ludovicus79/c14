<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class AdminCheck
{
    /**
     * Comprueba que haya un usuario logueado y que este tenga rol de administrador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check() || !Auth::user()->allowed){
            return redirect('/');
        }

        return $next($request);
    }
}
