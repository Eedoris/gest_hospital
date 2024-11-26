<?php

namespace App\Http\Controllers;

use App\Models\Analyse;
use Illuminate\Http\Request;

class AnalyseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validation des données
    $validated = $request->validate([
      'libelle' => 'required|string',
      'date_res' => 'required|date|before_or_equal:today',
      'state' => 'required|string',
      'result' => 'nullable|string',
    ]);

    // Créer une nouvelle analyse
    $analyse = new Analyse();
    $analyse->libelle = $validated['libelle'];
    $analyse->date_res = $validated['date_res'];
    $analyse->state = $validated['state'];
    $analyse->result = $validated['result'] ?? null;

    // Sauvegarder l'analyse
    $analyse->save();

    return redirect()->route('docpat', ['fragment' => 'consultations'])->with('success_analyse', 'Analyse ajoutée avec succès!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id_an)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id_an)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id_an)
  {
    // Valider les données de la requête
    $validated = $request->validate([
      'libelle' => 'required|string',
      'date_res' => 'required|date|before_or_equal:today',
      'state' => 'required|string',
      'result' => 'nullable|string',
    ]);

    // Trouver l'analyse par ID
    $analyse = Analyse::findOrFail($id_an);

    // Mettre à jour les champs
    $analyse->libelle = $validated['libelle'];
    $analyse->date_res = $validated['date_res'];
    $analyse->state = $validated['state'];
    $analyse->result = $validated['result'] ?? null;

    // Sauvegarder les modifications
    $analyse->save();

    return back()->with('success_analyse', 'Analyse mise à jour avec succès !');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id_an)
  {
    // Trouver l'analyse par ID
    $analyse = Analyse::findOrFail($id_an);

    // Supprimer l'analyse
    $analyse->delete();

    return back()->with('success_analyse', 'Analyse supprimée avec succès !');
  }
}
