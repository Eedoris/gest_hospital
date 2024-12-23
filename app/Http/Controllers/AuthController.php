<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
  // Affiche le formulaire de login
  public function showLoginForm()
  {
    return view('login.login');
  }

  // Gère la connexion
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      // Redirection selon le rôle
      $role = Auth::user()->statut;
      switch ($role) {
        case Users::ROLE_ADMIN:
          return redirect()->route('statistics.index');
        case Users::ROLE_DOCTOR:
          return redirect()->route('docpat');
        case Users::ROLE_SECRETAIRE:
          return redirect()->route('patientindex');
        default:
          return redirect('/login')->with('error', 'Rôle non reconnu.');
      }
    }

    return back()->withErrors([
      'email' => 'Les identifiants ne sont pas corrects.',
    ]);
  }

  public function logout(Request $request)
  {
    Auth::logout(); // Déconnecte l'utilisateur

    $request->session()->invalidate(); // Invalide la session
    $request->session()->regenerateToken(); // Régénère le token CSRF

    return redirect('/'); // Redirige vers la page de login
  }


}
