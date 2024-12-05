<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Analyse;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\AnalyseDisponible;

class ConsultationController extends Controller
{

  public function index($uuid)
  {
    $patient = Patient::where('uuid', $uuid)->firstOrFail();
    $consultations = Consultation::with(['analyses', 'prescriptions'])
      ->where('patient_id', $patient->id_pat)
      ->orderBy('date_cons', 'desc')
      ->get();



    return view('qoctor.consultation', compact('patient', 'consultations'));
  }
  public function create($id)
  {
    $patient = Patient::findOrFail($id);
    $consultations = collect(); // Collection vide
    return view('qoctor.consultation', compact('patient', 'consultations'));
  }




  public function store(Request $request, Patient $patient)
  {

    $validated = $request->validate([
      'date_cons' => [
        'required',
        'date',
        'date_equals:today',
        function ($attribute, $value, $fail) {
          if ($value !== now()->toDateString()) {
            $fail('La date de la consultation doit être aujourd\'hui.');
          }
        }
      ],
      'note' => 'required|string',
      'analyses' => 'nullable|array',
      'analyses.*.libelle' => 'required_with:analyses|string',
      'analyses.*.result' => 'nullable|string',
      'prescriptions' => 'nullable|array',
      'prescriptions.*.product' => 'required_with:prescriptions|string',
      'prescriptions.*.dosage' => 'required_with:prescriptions|string',
    ]);

    $consultation = $patient->consultations()->create([
      'date_cons' => $validated['date_cons'],
      'note' => $validated['note'],
    ]);


    if (!empty($validated['analyses'])) {
      foreach ($validated['analyses'] as $analyse) {
        $consultation->analyses()->create([
          'libelle' => $analyse['libelle'],
          'result' => $analyse['result'] ?? null,
          'date_res' => now(),
        ]);
      }
    }

    if (!empty($validated['prescriptions'])) {
      foreach ($validated['prescriptions'] as $prescription) {
        $consultation->prescriptions()->create([
          'product' => $prescription['product'],
          'dosage' => $prescription['dosage'],
        ]);
      }
    }

    return redirect()->route('consultations.index', $patient->uuid, )
      ->with('success_ajout', 'Consultation ajoutée avec succès.');
  }


  /* public function store(Request $request, $patient)
   {
     // Validation des données
     $validated = $request->validate([
       'date_cons' => 'required|date',
       'note' => 'required|string',
       'analyses' => 'nullable|array',
       'analyses.*.libelle' => 'required_with:analyses|string',
       'analyses.*.result' => 'nullable|string',
       'prescriptions' => 'nullable|array',
       'prescriptions.*.product' => 'required_with:prescriptions|string',
       'prescriptions.*.dosage' => 'required_with:prescriptions|string',
     ]);

     // Trouver le patient par ID
     $patient = Patient::findOrFail($patientId);

     // Création de la consultation
     $consultation = $patient->consultations()->create([
       'date_cons' => $validated['date_cons'],
       'note' => $validated['note'],
     ]);

     // Enregistrer les analyses si elles existent
     if (!empty($validated['analyses'])) {
       foreach ($validated['analyses'] as $data) {
         $consultation->analyses()->create([
           'libelle' => $data['libelle'],
           'result' => $data['result'] ?? null,
         ]);
       }
     }

     // Enregistrer les prescriptions si elles existent
     if (!empty($validated['prescriptions'])) {
       foreach ($validated['prescriptions'] as $data) {
         $consultation->prescriptions()->create([
           'product' => $data['product'],
           'dosage' => $data['dosage'],
         ]);
       }
     }

     // Retourner une réponse ou rediriger avec succès
     return redirect()->route('consultations.index', ['patientId' => $patientId])
       ->with('success', 'Consultation ajoutée avec succès');
   }*/
  public function edit($id)
  {
    $consultation = Consultation::with(['analyses', 'prescriptions'])->findOrFail($id);
    $patient = $consultation->patient;
    $consultations = $patient->consultations()->orderBy('date_cons', 'desc')->get();
    return view('qoctor.consultation', compact('consultation', 'patient', 'consultations'));
  }




  public function update(Request $request, $id_cons)
  {
    $request->validate([
      'date_cons' => 'required|date|date_equals:today',
      'note' => 'required|string|max:255',
      'analyses.*.libelle' => 'nullable|string',
      'analyses.*.result' => 'nullable|string',
      'prescriptions.*.product' => 'nullable|string',
      'prescriptions.*.dosage' => 'nullable|string',
    ]);

    $consultation = Consultation::findOrFail($id_cons);

    // Mise à jour de la consultation
    $consultation->date_cons = $request->date_cons;
    $consultation->note = $request->note;
    $consultation->save();

    // Gestion des suppressions d'analyses
    if ($request->filled('analyses_to_delete')) {
      $analysesToDelete = explode(',', $request->analyses_to_delete);
      Analyse::whereIn('id_an', $analysesToDelete)->delete();
    }

    // Mise à jour des analyses
    if ($request->has('analyses')) {
      foreach ($request->analyses as $id_an => $analyseData) {
        if (is_numeric($id_an)) {
          // Si l'ID existe, on met à jour
          $analyse = Analyse::find($id_an);
          if ($analyse) {
            $analyse->update($analyseData);
          }
        } elseif (!empty($analyseData['libelle'])) {
          // Si l'ID n'existe pas, on crée une nouvelle analyse
          $consultation->analyses()->create([
            'libelle' => $analyseData['libelle'],
            'result' => $analyseData['result'] ?? null,
            'date_res' => now(),
          ]);
        }
      }
    }

    // Gestion des suppressions de prescriptions
    if ($request->filled('prescriptions_to_delete')) {
      \Log::info('Prescriptions to delete: ' . $request->prescriptions_to_delete);
      $prescriptionsToDelete = explode(',', $request->prescriptions_to_delete);
      Prescription::whereIn('id_pres', $prescriptionsToDelete)->delete();


    }


    // Mise à jour des prescriptions
    if ($request->has('prescriptions')) {
      foreach ($request->prescriptions as $id_pres => $prescriptionData) {
        if (is_numeric($id_pres)) {
          // Si l'ID existe, on met à jour
          $prescription = Prescription::find($id_pres);
          if ($prescription) {
            $prescription->update($prescriptionData);
          }
        } elseif (!empty($prescriptionData['product'])) {
          // Si l'ID n'existe pas, on crée une nouvelle prescription
          $consultation->prescriptions()->create([
            'product' => $prescriptionData['product'],
            'dosage' => $prescriptionData['dosage'],
          ]);
        }
      }
    }

    return redirect()->route('consultations.index', [$consultation->patient->uuid, 'fragment' => 'historique'])
      ->with('success_history', 'Consultation mise à jour avec succès !');
  }


  public function print($id)
  {
    $consultation = Consultation::with(['analyses', 'prescriptions'])->findOrFail($id);
    return view('qoctor.print', compact('consultation'));
  }

  public function destroy($id_cons)
  {
    $consultation = Consultation::findOrFail($id_cons);

    $consultation->analyses()->delete();
    $consultation->prescriptions()->delete();
    $consultation->delete();

    return redirect()->back()->with('success_history', 'Consultation supprimée avec succès !');
  }
  public function history()
  {

    $consultations = Consultation::with(['doctor', 'patient'])->get();

    return view('admin.history', compact('consultations'));
  }



}
