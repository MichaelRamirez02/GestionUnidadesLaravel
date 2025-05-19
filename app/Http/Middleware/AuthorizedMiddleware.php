<?php

namespace App\Http\Middleware;

use App\Helpers\RoleHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorizedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // Valida si hay sesión
        if (!Auth::check()) {

            return redirect()->route('login');
        }

        if (!empty($permission)) {

            $isAuthorized = RoleHelper::isAuthorized($permission);

            if (!$isAuthorized) {

                abort(403, 'No hay autorización');
            }
        }

        return $next($request);
    }
}
