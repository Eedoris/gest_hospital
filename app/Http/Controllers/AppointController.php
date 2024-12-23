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
use Illuminate\Support\Facades\Crypt;

class AppointController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $services = Service::all();
    // Filtrer uniquement les rendez-vous avec le statut "Prévu" ou "Reprogrammé"
    $appoints = Appoint::with('service')->whereIn('status', ['Prévu', 'Reprogrammé'])->get();

    $appointments = Appoint::with('service')->whereIn('status', ['Annulé'])->get();
    $completes = Appoint::with('service')->whereIn('status', ['Effectué'])->get();

    return view('patient.rdv.appoint', compact('appoints', 'services', 'appointments', 'completes'));
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
        // 'date_app' => 'required|date|after_or_equal:today',
        // 'time_app' => 'required|date_format:H:i',
        'service_id' => 'required|integer|exists:services,id_serv',
      ]);

      if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
      }
      $appoint->update([
        'name' => $request->name,
        'surname' => $request->surname,
        'contact' => $request->contact,
        // 'date_app' => $request->date_app,
        // 'time_app' => $request->time_app,
        'service_id' => $request->service_id,
      ]);

      return redirect()->route('appointindex')->with('success', 'Rendez-vous mis à jour avec succès.');

    } catch (Exception $e) {
      Log::error('Erreur lors de la mise à jour : ' . $e->getMessage());
      return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
    }
  }


  public function cancel($id)
  {
    $id = decrypt($id);
    $appointment = Appoint::find($id);

    if ($appointment) {
      $appointment->status = 'Annulé';
      $appointment->save();
    }

    return redirect()->route('appointindex', ['tab' => 'annule']);
  }


  // public function complete($id)
  // {
  //   try {
  //     $decryptedId = Crypt::decrypt($id);
  //     $appoint = Appoint::findOrFail($decryptedId);
  //     $appoint->status = 'Effectué';
  //     $appoint->save();

  //     return redirect()->route('appointindex')->with('success', 'Rendez-vous marqué comme effectué.');
  //   } catch (Exception $e) {
  //     Log::error('Erreur lors de la complétion : ' . $e->getMessage());
  //     return redirect()->route('appointindex')->with('error', 'Erreur lors de la complétion.');
  //   }
  // }
  public function complete($id)
  {
    try {
      $appoint = Appoint::findOrFail(decrypt($id));

      // Vérifier si la date du rendez-vous est passée
      if ($appoint->date_app->isFuture()) {
        return redirect()->back()->with('error', 'Vous ne pouvez pas marquer ce rendez-vous comme effectué avant la date prévue.');
      }

      // Marquer le rendez-vous comme "Effectué"
      $appoint->status = 'Effectué';
      $appoint->save();

      return redirect()->back()->with('success', 'Rendez-vous marqué comme effectué.');
    } catch (Exception $e) {
      Log::error($e);
      return redirect()->back()->with('error', 'Une erreur est survenue.');
    }
  }

  /*programmer*/

  public function showRescheduleForm($id)
  {
    try {
      $token = encrypt($id); // Crée un token encrypté
      $appoint = Appoint::findOrFail($id);
      return view('patient.rdv.reschedule', compact('appoint', 'token'));
    } catch (Exception $e) {
      Log::error('Erreur lors de l\'affichage du formulaire de reprogrammation : ' . $e->getMessage());
      return redirect()->route('appointindex')->with('error', 'Erreur lors de l\'affichage du formulaire.');
    }
  }


  public function reschedule(Request $request)
  {
    try {
      // Décryptage de l'ID du rendez-vous
      $appointId = decrypt($request->token);

      // Récupération du rendez-vous
      $appoint = Appoint::findOrFail($appointId);

      // Validation des nouvelles données
      $validate = Validator::make($request->all(), [
        'date_app' => 'required|date|after_or_equal:today',
        'time_app' => 'required|date_format:H:i',
      ], [
        'date_app.after_or_equal' => 'La nouvelle date doit être égale ou postérieure à aujourd\'hui.',
        'time_app.date_format' => 'Le format de l\'heure doit être HH:MM.',
      ]);

      if ($validate->fails()) {
        return redirect()->back()
          ->withErrors($validate)
          ->withInput();
      }

      // Mise à jour des données du rendez-vous
      $appoint->update([
        'date_app' => $request->date_app,
        'time_app' => $request->time_app,
        'status' => 'Reprogrammé', // Mise à jour du statut
      ]);

      return redirect()->route('appointindex')->with('success', 'Rendez-vous reprogrammé avec succès.');
    } catch (Exception $e) {
      Log::error('Erreur lors de la reprogrammation : ' . $e->getMessage());
      return redirect()->route('appointindex')->with('error', 'Erreur : ' . $e->getMessage());
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
