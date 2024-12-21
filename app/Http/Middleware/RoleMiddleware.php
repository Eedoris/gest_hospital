<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, ...$roles)
  {
    // Vérifier si l'utilisateur est authentifié
    if (Auth::check()) {
      $user = Auth::user();

      // Vérifier si l'utilisateur a l'un des rôles spécifiés
      if ($user->hasAnyRole($roles)) {
        return $next($request);
      }
    }

    // Rediriger si l'accès est interdit
    return redirect('/login')->with('error', 'Accès non autorisé.');
  }
}

