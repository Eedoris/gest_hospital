<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    //
    DB::table('services')->insert([
      [
        'serv_name' => 'Cardiologie',
        'description' => 'Soins cardiaques',
      ],
      [
        'serv_name' => 'Gynecologie',
        'description' => 'Soins de la peau',
      ],
      [
        'serv_name' => 'Pédiatrie',
        'description' => 'prise en charge des enfants',
      ],
      [
        'serv_name' => 'Dermatologie',
        'description' => 'Soins de la peau',
      ],
      [
        'serv_name' => 'Radiographie',
        'description' => 'examen d imagerie',
      ],
      [
        'serv_name' => 'Medecine générale',
        'description' => 'Soins en général',
      ],

    ]);

  }
}
