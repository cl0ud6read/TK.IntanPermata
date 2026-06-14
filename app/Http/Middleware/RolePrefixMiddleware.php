<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolePrefixMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;
            $urlRole = $request->route('role');

            if ($urlRole && $urlRole !== $userRole) {
                // If user tries to access another role's URL, redirect them to their own URL
                $newUrl = str_replace("/{$urlRole}/", "/{$userRole}/", $request->getRequestUri());
                return redirect($newUrl);
            }

            // Forget the parameter so it's not injected into controller methods!
            if ($urlRole) {
                $request->route()->forgetParameter('role');
            }
        }

        return $next($request);
    }
}
