<?php

namespace App\Http\Middleware;

use Closure;

class KorisnikPrijavljenProvera
{
    public function handle($request, Closure $next)
    {
        if($request->session()->has('korisnik')){
            return redirect(route('home'));
        }

        return $next($request);
    }
}
