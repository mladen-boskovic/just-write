<?php

namespace App\Http\Middleware;

use Closure;

class ErrorPageProvera
{
    public function handle($request, Closure $next)
    {
        if(!session('uspesnaPoruka') && !session('neuspesnaPoruka')){
            return redirect(route('home'));
        }

        return $next($request);
    }
}
