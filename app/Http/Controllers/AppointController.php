<?php

namespace App\Http\Controllers;

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
        'date_app' => 'required|date|after_or_equal:today',
        'service_id' => 'required|integer|exists:services,id_serv',
      ]);

      if ($validate->fails()) {
        return redirect()->back()
          ->withErrors($validate)
          ->withInput();
      }

      Appoint::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'date_app' => $request->date_app,
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


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    try {

      $id_appoint = decrypt($request->token);

      $appoint = Appoint::findOrFail($id_appoint);


      $validate = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'date_app' => 'required|date|after_or_equal:today',
        'service_id' => 'required|integer|exists:services,id_serv',
      ]);

      if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
      }
      $appoint->update([
        'name' => $request->name,
        'surname' => $request->surname,
        'date_app' => $request->date_app,
        'service_id' => $request->service_id,
      ]);

      return redirect()->route('appointindex')->with('success', 'Rendez-vous mis à jour avec succès.');
    } catch (Exception $e) {
      Log::error('Erreur lors de la mise à jour du rendez-vous : ' . $e->getMessage());
      return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
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
