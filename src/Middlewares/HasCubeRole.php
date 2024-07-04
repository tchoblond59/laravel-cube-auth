<?php

namespace Tchoblond59\CubeAuth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasCubeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @param  string  $module
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role, $module) : Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login'); // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
        }

        if (!$user->hasRole($role, $module)) {
            return redirect('unauthorized'); // Rediriger vers une page d'accès non autorisé ou autre action appropriée
        }
        return $next($request);
    }
}
