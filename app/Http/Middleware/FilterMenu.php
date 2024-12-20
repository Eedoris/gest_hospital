<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FilterMenu
{
  public function handle($request, Closure $next)
  {
    // Charger le menu JSON
    $menuData = json_decode(file_get_contents(resource_path('data/verticalMenu.json')));

    // Rôle de l'utilisateur connecté
    $userRole = Auth::check() ? Auth::user()->statut : 'guest';

    // Filtrer le menu
    foreach ($menuData->menu as $key => $menu) {
      if (isset($menu->roles) && !in_array($userRole, $menu->roles)) {
        unset($menuData->menu[$key]);
      } else {
        if (isset($menu->submenu)) {
          foreach ($menu->submenu as $subKey => $submenu) {
            if (isset($submenu->roles) && !in_array($userRole, $submenu->roles)) {
              unset($menu->submenu[$subKey]);
            }
          }
        }
      }
    }

    // Partager les données filtrées avec toutes les vues
    view()->share('menuData', $menuData->menu);

    return $next($request);
  }
}
