<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('consultations', function (Blueprint $table) {
      //
      $table->timestamps();
      $table->unsignedBigInteger('doctor_id');
      $table->unsignedBigInteger('patient_id');

      $table->foreign('doctor_id')->references('id_doctor')->on('doctors');
      $table->foreign('patient_id')->references('id_pat')->on('patients');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('consultations', function (Blueprint $table) {
      //
    });
  }
};
