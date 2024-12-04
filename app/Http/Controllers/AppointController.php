<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Appoint;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

class AppointController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $services = Service::all();
    $appoints = Appoint::with('service')->get();
    return view('patient.rdv.appoint', compact('appoints'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $services = Service::all();
    return view('patient.rdv.newappoint', compact('services'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {

      $validate = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'contact' => ['required', 'string', 'regex:/^(\+228)?\d{8}$/'],
        'date_app' => 'required|date|after_or_equal:today',
        'time_app' => 'required|date_format:H:i',
        'service_id' => 'required|integer|exists:services,id_serv',
      ], [
        'contact.regex' => 'Le numéro de téléphone doit commencer par +228 ou être suivi de 8 chiffres.',
        'date_app.after_or_equal' => 'La date de rendez-vous doit être égale ou postérieure à aujourd\'hui.',
        'time_app.date_format' => 'Le format de l\'heure doit être HH:MM.'
      ]);

      if ($validate->fails()) {
        return redirect()->back()
          ->withErrors($validate)
          ->withInput();
      }

      // dd($request->all());


      Appoint::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'contact' => $request->contact,
        'date_app' => $request->date_app,
        'time_app' => $request->time_app,
        'service_id' => $request->service_id,
      ]);

      return redirect()->route('appointindex')->with('success', 'Rendez-vous ajouté avec succès.');
    } catch (Exception $e) {
      Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
      return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
    }
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request)
  {
    try {
      $token = $request->query('token');
      $id_appoint = decrypt($token);

      $appoint = Appoint::findOrFail($id_appoint);
      $services = Service::all();
      return view('patient.rdv.rdvform', compact('appoint', 'token', 'services'));
    } catch (Exception $e) {
      Log::error('Erreur lors de l\'édition : ' . $e->getMessage());
      return redirect()->back()->with('error', 'Erreur lors de l\'édition : ' . $e->getMessage());
    }
  }

  public function searchPatient(Request $request)
  {
    $request->validate([
      'name' => 'required|string|min:2',
    ]);

    $patients = Patient::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->name) . '%'])
      ->orWhereRaw('LOWER(surname) LIKE ?', ['%' . strtolower($request->name) . '%'])
      ->get();

    return response()->json($patients);
  }



  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    try {
      $appointId = decrypt($request->token);
      Log::info("ID décrypté : " . $appointId);

      $appoint = Appoint::findOrFail($appointId);
      Log::info("Rendez-vous trouvé : " . $appoint->name);


      $validate = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'contact' => ['required', 'string', 'regex:/^(\+228)?\d{8}$/'],
        'date_app' => 'required|date|after_or_equal:today',
        'time_app' => 'required|date_format:H:i',
        'service_id' => 'required|integer|exists:services,id_serv',
      ]);

      if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
      }
      $appoint->update([
        'name' => $request->name,
        'surname' => $request->surname,
        'contact' => $request->contact,
        'date_app' => $request->date_app,
        'time_app' => $request->time_app,
        'service_id' => $request->service_id,
      ]);

      return redirect()->route('appointindex')->with('success', 'Rendez-vous mis à jour avec succès.');

    } catch (Exception $e) {
      Log::error('Erreur lors de la mise à jour : ' . $e->getMessage());
      return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
    }
  }





  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
