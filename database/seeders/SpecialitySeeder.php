<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitySeeder extends Seeder
{
  public function run()
  {
    DB::table('specialities')->insert([
      ['title' => 'Médecine générale'],
      ['title' => 'Cardiologie'],
      ['title' => 'Dermatologie'],
      ['title' => 'Pédiatrie'],
      ['title' => 'Orthopédie'],
      ['title' => 'Gynécologie'],
      ['title' => 'Neurologie'],
      ['title' => 'Ophtalmologie'],
      ['title' => 'Chirurgie générale'],
      ['title' => 'Psychiatrie']
    ]);
  }
}
