<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Prescription;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\WorksheetsetCellValueByColumnAndRow;



class StatisticsController extends Controller
{

  public function index()
  {
    $monthNames = [
      1 => 'Janvier',
      2 => 'Février',
      3 => 'Mars',
      4 => 'Avril',
      5 => 'Mai',
      6 => 'Juin',
      7 => 'Juillet',
      8 => 'Août',
      9 => 'Septembre',
      10 => 'Octobre',
      11 => 'Novembre',
      12 => 'Décembre'
    ];


    // Obtenez le numéro du mois si un mois est sélectionné
    $selectedMonthName = request('month');
    $selectedMonthNumber = array_search($selectedMonthName, $monthNames);

    $consultationsByMonth = Consultation::selectRaw('EXTRACT(MONTH FROM date_cons) as month, COUNT(*) as count')
      ->when($selectedMonthNumber, function ($query) use ($selectedMonthNumber) {
        return $query->whereRaw('EXTRACT(MONTH FROM date_cons) = ?', [$selectedMonthNumber]);
      })
      ->groupBy('month')
      ->get()
      ->map(function ($item) use ($monthNames) {
        return [
          'month' => $monthNames[$item->month],
          'count' => $item->count
        ];
      });

    // Filtrage des patients
    $selectedMonth = request('month');
    $newPatients = Patient::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
      ->groupBy('month')
      ->orderBy('month')
      ->get()
      ->map(function ($item) use ($monthNames) {
        return [
          'month' => $monthNames[$item->month],
          'count' => $item->count
        ];
      });

    $filteredPatients = $selectedMonth
      ? $newPatients->filter(fn($item) => $item['month'] === $selectedMonth)
      : $newPatients;

    // Mois avec le plus de nouveaux patients
    $monthWithMostPatients = $filteredPatients->sortByDesc('count')->first();

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
      'ageStats',
      'monthNames',
      'filteredPatients',
      'monthWithMostPatients',
      'monthNames',
      'selectedMonthName'
    ));
  }

  public function exportStatistics(Request $request)
  {
    // Validation des paramètres de la requête
    $request->validate([
      'start_date' => 'nullable|date',
      'end_date' => 'nullable|date',
    ]);

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // En-têtes du fichier Excel
    $headers = [
      'A1' => 'Mois',
      'B1' => 'Nombre de consultations',
      'C1' => 'Nombre de nouveaux patients',
      'D1' => 'Hommes',
      'E1' => 'Femmes',
      'F1' => 'Tranche d\'âge : 0-17',
      'G1' => 'Tranche d\'âge : 18-35',
      'H1' => 'Tranche d\'âge : 36+',
      'I1' => 'Médicament le plus prescrit'
    ];

    foreach ($headers as $cell => $header) {
      $sheet->setCellValue($cell, $header);
    }

    // Liste des mois en français
    $monthNames = [
      1 => 'Janvier',
      2 => 'Février',
      3 => 'Mars',
      4 => 'Avril',
      5 => 'Mai',
      6 => 'Juin',
      7 => 'Juillet',
      8 => 'Août',
      9 => 'Septembre',
      10 => 'Octobre',
      11 => 'Novembre',
      12 => 'Décembre',
    ];

    // Données dynamiques
    $consultationsByMonth = $this->applyDateFilter(
      Consultation::selectRaw('EXTRACT(MONTH FROM date_cons) as month, COUNT(*) as count'),
      $startDate,
      $endDate,
      'date_cons'
    )->groupBy('month')->get()->keyBy('month');

    $newPatientsByMonth = $this->applyDateFilter(
      Patient::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count'),
      $startDate,
      $endDate
    )->groupBy('month')->get()->keyBy('month');

    $genderStats = $this->applyDateFilter(
      Patient::selectRaw('EXTRACT(MONTH FROM created_at) as month, sex, COUNT(*) as count'),
      $startDate,
      $endDate
    )->groupBy('month', 'sex')->get();

    $ageStats = $this->applyDateFilter(
      Patient::selectRaw("
              EXTRACT(MONTH FROM created_at) as month,
              CASE
                  WHEN EXTRACT(YEAR FROM AGE(date_of_birth)) < 18 THEN '0-17'
                  WHEN EXTRACT(YEAR FROM AGE(date_of_birth)) BETWEEN 18 AND 35 THEN '18-35'
                  ELSE '36+'
              END as age_range,
              COUNT(*) as count
          "),
      $startDate,
      $endDate
    )->groupBy('month', 'age_range')->get();

    $medicationsByMonth = $this->applyDateFilter(
      Prescription::selectRaw('EXTRACT(MONTH FROM created_at) as month, product, COUNT(*) as count'),
      $startDate,
      $endDate
    )->groupBy('month', 'product')->orderBy('count', 'desc')->get();

    // Insérer les données dans Excel
    $row = 2;
    foreach ($monthNames as $monthNum => $monthName) {
      $sheet->setCellValue("A{$row}", $monthName);
      $sheet->setCellValue("B{$row}", $consultationsByMonth[$monthNum]->count ?? 0);
      $sheet->setCellValue("C{$row}", $newPatientsByMonth[$monthNum]->count ?? 0);

      // Genre
      $maleCount = $genderStats->where('month', $monthNum)->where('sex', 'Masculin')->sum('count');
      $femaleCount = $genderStats->where('month', $monthNum)->where('sex', 'Féminin')->sum('count');
      $sheet->setCellValue("D{$row}", $maleCount);
      $sheet->setCellValue("E{$row}", $femaleCount);

      // Tranche d'âge
      $age0_17 = $ageStats->where('month', $monthNum)->where('age_range', '0-17')->sum('count');
      $age18_35 = $ageStats->where('month', $monthNum)->where('age_range', '18-35')->sum('count');
      $age36Plus = $ageStats->where('month', $monthNum)->where('age_range', '36+')->sum('count');
      $sheet->setCellValue("F{$row}", $age0_17);
      $sheet->setCellValue("G{$row}", $age18_35);
      $sheet->setCellValue("H{$row}", $age36Plus);

      // Médicament le plus prescrit
      $topMedication = $medicationsByMonth->where('month', $monthNum)->first();
      $sheet->setCellValue("I{$row}", $topMedication->product ?? 'N/A');

      $row++;
    }

    // Téléchargement du fichier
    $writer = new Xlsx($spreadsheet);
    $fileName = 'Statistiques_' . now()->format('Y-m-d') . '.xlsx';
    $temp_file = tempnam(sys_get_temp_dir(), $fileName);
    $writer->save($temp_file);

    return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
  }

  /**
   * Applique les filtres de date à une requête.
   */
  private function applyDateFilter($query, $startDate, $endDate, $column = 'created_at')
  {
    if ($startDate) {
      $query->where($column, '>=', $startDate);
    }
    if ($endDate) {
      $query->where($column, '<=', $endDate);
    }
    return $query;
  }


}
