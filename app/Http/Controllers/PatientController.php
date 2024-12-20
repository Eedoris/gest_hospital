<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;


class PatientController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
    $patients = Patient::orderBy('created_at', 'asc')->get();

    return view('patient.index', compact('patients'));

  }
  public function indexdoctor()
  {
    //
    $patients = Patient::all();
    return view('qoctor.pat', compact('patients'));

  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
    return view('patient.form');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      // Validation des données
      $validate = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'date_of_birth' => 'required|date|before_or_equal:today', // Validation pour la date
        'sex' => 'required|string',
        'contact' => [
          'required',
          'string',
          'regex:/^(\+228)?\d{8}$/'
        ],
        'adress' => 'required|string|max:255',
      ], [
        'date_of_birth.before_or_equal' => 'La date de naissance ne peut pas être dans le futur.',
        'contact.regex' => 'Le numéro de contact doit contenir exactement 8 chiffres ou commencer par +228 suivi de 8 chiffres.',
      ]);

      // Vérification des erreurs de validation
      if ($validate->fails()) {
        return redirect()->back()
          ->withErrors($validate)
          ->withInput();
      }

      // Enregistrement du patient
      $patient = Patient::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'date_of_birth' => $request->date_of_birth,
        'sex' => $request->sex,
        'adress' => $request->adress,
        'contact' => $request->contact,
        'uuid' => (string) Str::uuid(),
      ]);

      return redirect()->route('patientindex')->with('success', 'Patient ajouté avec succès.');
    } catch (Exception $e) {
      Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
      return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
    }
  }


  /**
   * Display the specified resource.
   */
  public function show($uuid)
  {
    $patient = Patient::where('uuid', $uuid)->with('consultations')->firstOrFail();

    // Affiche la vue pour le dossier avec l'option d'impression
    return view('qoctor.show', compact('patient'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($uuid)
  {
    $patient = Patient::where('uuid', $uuid)->firstOrFail();
    return view('patient.edit', compact('patient'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $uuid)
  {
    //
    $validate = $request->validate([
      'name' => 'required|string|max:255',
      'surname' => 'required|string|max:255',
      'date_of_birth' => 'required|date|before_or_equal:today',
      'sex' => 'required|string',
      'contact' => [
        'required',
        'string',
        'regex:/^(\+228)?\d{8}$/'
      ],
      'adress' => 'required|string|max:255',
    ], [
      'date_of_birth.before_or_equal' => 'La date de naissance ne peut pas être dans le futur.',
      'contact.regex' => 'Le numéro de contact doit contenir exactement 8 chiffres ou commencer par +228 suivi de 8 chiffres.',
    ]);

    try {
      $patient = Patient::where('uuid', $uuid)->firstOrFail();
      $patient->update($validate);

      return redirect()->route('patientindex')->with('success', 'Modification effectué ');
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
