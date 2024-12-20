<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {

    $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
    $verticalMenuData = json_decode($verticalMenuJson);

    // Share all menuData to all the views
    $this->app->make('view')->share('menuData', [$verticalMenuData]);


  }
}


// namespace App\Providers;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Routing\Route;
// use Illuminate\Support\Facades\View;
// use Illuminate\Support\ServiceProvider;

// class MenuServiceProvider extends ServiceProvider
// {
//   public function register(): void
//   {
//     //
//   }
//     public function boot()
//     {
//       $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
//       $verticalMenuData = json_decode($verticalMenuJson);

//         View::composer('*', function ($view) use ($verticalMenuData) {
//             if (Auth::check()) {
//                 $user = Auth::user();
//                 $filteredMenu = $this->filterMenuByRole($verticalMenuData['menu'], $user->statut); // Récupère les menus filtrés pour le rôle
//                 $view->with('menuData', [$filteredMenu]); // Partage les données du menu avec la vue
//             } else {
//                 $view->with('menuData', []); // Aucun menu pour les utilisateurs non authentifiés
//             }
//         });
//     }

//     /**
//      * Filtrer les menus par rôle.
//      *
//      * @param array $menu
//      * @param string $role
//      * @return array
//      */
//     private function filterMenuByRole(array $menu, string $role): array
//     {
//         foreach ($menu as $key => &$menuItem) {
//             // Supprimer l'élément si le rôle ne correspond pas
//             if (isset($menuItem['roles']) && !in_array($role, $menuItem['roles'])) {
//                 unset($menu[$key]);
//                 continue;
//             }

//             // Filtrage des sous-menus
//             if (isset($menuItem['submenu'])) {
//                 $menuItem['submenu'] = $this->filterMenuByRole($menuItem['submenu'], $role);

//                 // Si aucun sous-menu valide, supprime le menu principal
//                 if (empty($menuItem['submenu'])) {
//                     unset($menu[$key]);
//                 }
//             }
//         }

//         // Réindexer le tableau après suppression
//         return array_values($menu);
//     }
