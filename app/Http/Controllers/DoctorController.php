<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\Specialty;
use App\Models\Service;
use App\Models\Users;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
  // Affiche la liste des médecins
  public function index()
  {
    // Récupère les médecins avec leurs utilisateurs, spécialités et services associés
    $doctors = Doctor::with('user', 'speciality', 'service')->get();
    $users = Users::where('statut', 'medecin')->get();
    $specialities = Speciality::all();
    $services = Service::all();

    return view('admin.gestdocteur', compact('doctors', 'users', 'specialities', 'services'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'user_id' => 'required|exists:users,id_user', // Vérifie que l'utilisateur existe
      'doctor_title' => 'required|string|max:255', // Vérifie le titre
      'id_spe' => 'required|exists:specialities,id_spe', // Vérifie que la spécialité existe
      'id_serv' => 'required|exists:services,id_serv', // Vérifie que le service existe
    ]);

    Doctor::create([
      'user_id' => $validated['user_id'],
      'doctor_title' => $validated['doctor_title'],
      'id_spe' => $validated['id_spe'],
      'id_serv' => $validated['id_serv'],
    ]);

    return redirect()->route('doctor.index')->with('success', 'Médecin ajouté avec succès.');
  }

}
