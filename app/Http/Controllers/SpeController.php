<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpeController extends Controller
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
    $request->validate([
      'title' => 'required',
    ]);
    $existingSpeciality = Speciality::where('title', $request->title)->first();
    if ($existingSpeciality) {
      return redirect()
        ->route('service.index', ['fragment' => 'specialite'])
        ->with('error_specialite', 'Cette spécialité existe déjà!');
    }

    Speciality::create($request->all());
    return redirect()->route('service.index', ['fragment' => 'specialite'])->with('success_specialite', 'Specialité ajoutée avec succès!');
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
  public function update(Request $request, string $id_spe)
  {
    //
    $validated = $request->validate([
      'title' => 'required|string|max:255',
    ]);

    $specialite = Speciality::findOrFail($id_spe);
    $specialite->update($validated);
    return redirect()->route('service.index', ['fragment' => 'specialite'])->with('success_specialite', 'Specialité ée avec succès!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
