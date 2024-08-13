<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('app_sesion')) {
            if (session("app_sesion") != "xLXAiX0fFTjLKEiJam7X57") {
                return redirect('/');
            }
            return redirect('/');
        }
        return $next($request);
    }
}
