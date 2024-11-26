<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
  public function index()
  {
    $users = Users::all();
    return view('admin.userliste', compact('users'));
  }




  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'surname' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|confirmed|min:6',
      'statut' => 'required|string',
    ]);


    Users::create([
      'name' => $validated['name'],
      'surname' => $validated['surname'],
      'email' => $validated['email'],
      'password' => bcrypt($validated['password']),
      'statut' => $validated['statut'],
      'uuid' => (string) Str::uuid(),
    ]);

    return redirect()->route('user.index')->with('success', 'Utilisateur ajouté avec succès.');
  }

  public function update(Request $request, $uuid)
  {
    $user = Users::where('uuid', $uuid)->firstOrFail();

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'surname' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
      'statut' => 'required|string',
    ]);


    $user->update([
      'name' => $validated['name'],
      'surname' => $validated['surname'],
      'email' => $validated['email'],
      'statut' => $validated['statut'],
    ]);

    return redirect()->route('user.index')->with('success', 'Utilisateur modifié avec succès.');
  }


  public function destroy($uuid)
  {
    $user = Users::where('uuid', $uuid)->firstOrFail();
    $user->delete();

    return redirect()->route('user.index')->with('success', 'Utilisateur supprimé avec succès.');
  }

}
