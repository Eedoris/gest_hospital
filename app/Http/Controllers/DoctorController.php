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
    $users = Users::where('statut', 'docteur')->get();
    $specialities = Speciality::all();
    $services = Service::all();

    return view('admin.gestdocteur', compact('doctors', 'users', 'specialities', 'services'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'user_id' => 'required|exists:users,id_user',
      'doctor_title' => 'required|string|max:255',
      'id_spe' => 'required|exists:specialities,id_spe',
      'id_serv' => 'required|exists:services,id_serv',
    ]);

    Doctor::create([
      'user_id' => $validated['user_id'],
      'doctor_title' => $validated['doctor_title'],
      'id_spe' => $validated['id_spe'],
      'id_serv' => $validated['id_serv'],
    ]);

    return redirect()->route('doctor.index')->with('success', 'Docteur ajouté avec succès.');
  }

  public function update(Request $request, $id_doctor)
  {

    $request->validate([
      'user_id' => 'required|exists:users,id_user',
      'doctor_title' => 'required|string|max:255',
      'id_spe' => 'required|exists:specialities,id_spe',
      'service_id' => 'required|exists:services,id_serv',
    ]);


    $doctor = Doctor::findOrFail($id_doctor);


    $doctor->user_id = $request->input('user_id');
    $doctor->doctor_title = $request->input('doctor_title');
    $doctor->id_spe = $request->input('id_spe');
    $doctor->id_serv = $request->input('service_id');


    $doctor->save();


    return redirect()->route('doctor.index')->with('success', 'Médecin mis à jour avec succès !');
  }


}
