<?php

namespace Tchoblond59\CubeAuth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('token')) {
            if(Auth::check())
            {
                return $next($request);
            }
            else
            {
                abort(403);
            }
        }
        else {
            abort(403);
        }


    }
}
