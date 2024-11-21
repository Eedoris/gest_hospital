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
    //
    Schema::create('appoints', function (Blueprint $table) {
      $table->id('id_appoint');
      $table->date('date_app');
      $table->string('state');
      $table->string('reason');
      $table->timestamps();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('doctor_id');
      $table->unsignedBigInteger('patient_id');



      $table->foreign('user_id')->references('id_user')->on('user');
      $table->foreign('doctor_id')->references('id_doctor')->on('doctor');
      $table->foreign('patient_id')->references('id_pat')->on('patients');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
