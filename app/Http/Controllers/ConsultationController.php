<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Analyse;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\AnalyseDisponible;

class ConsultationController extends Controller
{
  //
  public function index($uuid)
  {
    $patient = Patient::where('uuid', $uuid)->firstOrFail();
    $consultations = Consultation::where('patient_id', $patient->id_pat)->get();
    $analyses = Analyse::all();
    $an_disponibles = AnalyseDisponible::all();

    return view('qoctor.consultation', compact('patient', 'consultations', 'analyses', 'an_disponibles'));
  }



  public function store(Request $request)
  {
    $request->validate([
      'patient_id' => 'required|exists:patients,id_pat',
      'date_cons' => 'required|date',
      'note' => 'required|string',
      'analyses' => 'nullable|array',
      'analyses.*' => 'exists:analyses,id_an',
    ]);

    $consultation = Consultation::create($request->only(['patient_id', 'date_cons', 'note']));

    if ($request->has('analyses')) {
      foreach ($request->analyses as $analyseId) {
        Analyse::where('id_an', $analyseId)->update(['consultation_id' => $consultation->id]);
      }
    }


    return back()->with('success', 'Consultation ajoutée avec succès !');
  }
}
