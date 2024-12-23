<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;


return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {

  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
    $exceptions->renderable(function (\Throwable $e) {
      // Vérifie si l'exception est une TokenMismatchException
      if ($e instanceof TokenMismatchException) {
        return redirect()->route('login')->with('error', 'Votre session a expiré. Veuillez vous reconnecter.');
      }
    });
  })->create();
