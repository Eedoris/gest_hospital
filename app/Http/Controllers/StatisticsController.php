<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Prescription;



class StatisticsController extends Controller
{

  public function index()
  {
    $consultationsByMonth = Consultation::selectRaw('EXTRACT(MONTH FROM date_cons) as month, COUNT(*) as count')
      ->groupBy('month')
      ->get()
      ->mapWithKeys(function ($item) {
        return [$item->month => $item->count];
      });

    $newPatients = Patient::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
      ->groupBy('month')
      ->get()
      ->mapWithKeys(function ($item) {
        return [$item->month => $item->count];
      });

    $medications = Prescription::selectRaw('product, COUNT(*) as count')
      ->groupBy('product')
      ->orderByDesc('count')
      ->limit(10)
      ->get();

    $genderStats = Patient::selectRaw('sex, COUNT(*) as count')
      ->groupBy('sex')
      ->get();

    $ageStats = Patient::selectRaw("CASE WHEN EXTRACT(YEAR FROM AGE(date_of_birth)) < 18 THEN '0-17'
                  WHEN EXTRACT(YEAR FROM AGE(date_of_birth)) BETWEEN 18 AND 35 THEN '18-35'
                  ELSE '36+' END as age_range, COUNT(*) as count")
      ->groupBy('age_range')
      ->get();

    return view('stats.statistics', compact(
      'consultationsByMonth',
      'newPatients',
      'medications',
      'genderStats',
      'ageStats'
    ));
  }



  /* public function exportStatistics()
   {
     // Créez un nouveau document Excel
     $spreadsheet = new Spreadsheet();
     $sheet = $spreadsheet->getActiveSheet();

     // Définissez des en-têtes
     $sheet->setCellValue('A1', 'Mois');
     $sheet->setCellValue('B1', 'Nombre de consultations');
     $sheet->setCellValue('C1', 'Nombre de nouveaux patients');

     // Récupérez vos données (exemple statique pour le moment)
     $data = [
       ['Janvier', 25, 12],
       ['Février', 18, 8],
       ['Mars', 30, 20],
     ];

     // Insérez les données dans le fichier
     $row = 2;
     foreach ($data as $entry) {
       $sheet->setCellValue('A' . $row, $entry[0]);
       $sheet->setCellValue('B' . $row, $entry[1]);
       $sheet->setCellValue('C' . $row, $entry[2]);
       $row++;
     }

     // Générer le fichier Excel
     $writer = new Xlsx($spreadsheet);
     $fileName = 'statistiques.xlsx';
     $tempFilePath = tempnam(sys_get_temp_dir(), $fileName);
     $writer->save($tempFilePath);

     // Retourner le fichier pour téléchargement
     return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
   }*/


}
