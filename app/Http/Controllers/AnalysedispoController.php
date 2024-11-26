<?php

namespace App\Http\Controllers;

use App\Models\Analyse;
use App\Models\AnalyseDisponible;
use Illuminate\Http\Request;

class AnalysedispoController extends Controller
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
    $request->validate([
      'libelle' => 'required',
    ]);

    AnalyseDisponible::create($request->all());

    // Redirige vers l'onglet "analyses_dispo"
    return redirect()->route('service.index', ['fragment' => 'analyses_dispo'])->with('success_analysis', 'Analyse ajoutée avec succès!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
    $validated = $request->validate([
      'libelle' => 'required|string|max:255',
    ]);

    $an_disponible = AnalyseDisponible::findOrFail($id);
    $an_disponible->update($validated);

    return redirect()->back()->with('success_analysis', 'Analyse modifié avec succès!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
    $an_disponible = AnalyseDisponible::findOrFail($id);
    $an_disponible->delete();

    return redirect()->back()->with('success_analysis', 'Analyse supprimée avec succès!');
  }
}
