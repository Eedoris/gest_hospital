<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Analyse;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\AnalyseDisponible;

class ConsultationController extends Controller
{
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
    ]);

    $consultation = Consultation::create($request->only(['patient_id', 'date_cons', 'note']));

    /* if ($request->has('analyses')) {
       foreach ($request->analyses as $analyseId) {
         Analyse::where('id_an', $analyseId)->update(['consultation_id' => $consultation->id]);
       }
     }*/

    return redirect()->route('docpat', ['fragment' => 'consultations'])->with('success_consultation', 'Consultation ajoutée avec succès!');
  }

  public function update(Request $request, string $id_cons)
  {
    $validated = $request->validate([
      'date_cons' => 'required|date',
      'note' => 'required|string',
      'analyses' => 'nullable|array',
    ]);

    $consultation = Consultation::findOrFail($id_cons);

    $consultation->update([
      'date_cons' => $validated['date_cons'],
      'note' => $validated['note'],
    ]);
    /*if ($request->has('analyses')) {

      Analyse::where('consultation_id', $consultation->id_cons)->update(['consultation_id' => null]);


      foreach ($request->analyses as $analyseId) {
        Analyse::where('id_an', $analyseId)->update(['consultation_id' => $consultation->id]);
      }
    }*/

    return redirect()->back()->with('success_consultation', 'Consultation modifiée avec succès!');
  }

  public function history(Request $request)
  {
    $query = Consultation::with(['doctor', 'patient']);

    if ($request->filled('doctor_id')) {
      $query->where('doctor_id', $request->doctor_id);
    }

    if ($request->filled('patient_id')) {
      $query->where('patient_id', $request->patient_id);
    }

    $consultations = $query->orderBy('date_cons', 'desc')->get();

    $doctors = Users::where('statut', 'medecin')->get();
    $patients = Patient::all();

    return view('admin.history', compact('consultations', 'doctors', 'patients'));
  }



  public function destroy(string $id_cons)
  {
    $consultation = Consultation::findOrFail($id_cons);

    /*Analyse::where('consultation_id', $consultation->id)->update(['consultation_id' => null]);*/

    $consultation->delete();

    return redirect()->back()->with('success_consultation', 'Consultation supprimée avec succès!');
  }
}
