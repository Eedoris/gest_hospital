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
    Schema::create('doctors', function (Blueprint $table) {
      $table->id('id_doctor');
      $table->string('doctor_title');
      $table->unsignedBigInteger('id_serv');
      $table->unsignedBigInteger('id_spe');

      $table->foreign('id_serv')->references('id_serv')->on('service');
      $table->foreign('id_spe')->references('id_spe')->on('speciality');




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
