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
    $analyse->libelle = $request->libelle;
    $analyse->date_res = $request->date_res;
    $analyse->state = $request->state;
    $analyse->result = $request->description;

    // Sauvegarder l'analyse
    $analyse->save();

    return back()->with('success', 'Analyse ajoutée avec succès !');
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
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
