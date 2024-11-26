<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\AnalyseDisponible;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
    $services = Service::all();
    $an_disponibles = AnalyseDisponible::all();
    return view('admin.addan', compact('services', 'an_disponibles'));
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
      'serv_name' => 'required',
      'description' => 'required',
    ]);

    Service::create($request->all());

    // Redirige vers l'onglet "services"
    return redirect()->route('service.index', ['fragment' => 'services'])->with('success_service', 'Service ajouté avec succès!');
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
  public function update(Request $request, string $id_serv)
  {
    //

    $validated = $request->validate([
      'serv_name' => 'required|string|max:255',
      'description' => 'required|string',
    ]);

    $service = Service::findOrFail($id_serv);
    $service->update($validated);

    return redirect()->back()->with('success_service', 'Service modifié avec succès!');
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id_serv)
  {
    //
    $service = Service::findOrFail($id_serv);
    $service->delete();

    return redirect()->back()->with('success_service', 'Service suprimé avec succès!');
  }
}








