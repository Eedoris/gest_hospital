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
    Schema::create('prescriptions', function (Blueprint $table) {
      $table->id('id_pres');
      $table->string('product');
      $table->string('dosage');
      $table->unsignedBigInteger('consultation_id');

      $table->foreign('consultation_id')->references('id_cons')->on('consultation');


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
