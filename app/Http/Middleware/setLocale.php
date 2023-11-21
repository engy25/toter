<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class setLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $lang=  substr($request->header('Accept-Language'),-2);
        $lang ? app()->setLocale($lang) :app()->setLocale("en");

        // $request->header('Accept-Language') ? app()->setLocale($request->header('Accept-Language')) : app()->setLocale('en');
        
        return $next($request);
    }
}
