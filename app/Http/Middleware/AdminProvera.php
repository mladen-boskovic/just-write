<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class AdminProvera
{
    public function handle($request, Closure $next)
    {
        if(!$request->session()->has('korisnik')){
            Log::critical("Korisnik pokušava da uđe na admin panel! IP adresa: " . $request->ip());
            return redirect(route('home'));
        }
        if($request->session()->get('korisnik')->uloga != "Admin"){
            Log::critical("Korisnik pokušava da uđe na admin panel! IP adresa: " . $request->ip());
            return redirect(route('home'));
        }

        return $next($request);
    }
}
