<?php

namespace App\Http\Middleware;

use Closure;

class ResetPasswordTokenProvera
{
    public function handle($request, Closure $next)
    {
        if(!session('reset_password')){
            return redirect(route('home'));
        }

        return $next($request);
    }
}
