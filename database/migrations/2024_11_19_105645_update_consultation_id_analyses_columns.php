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
    Schema::table('analyses', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('consultation_id');

      $table->foreign('consultation_id')->references('id_cons')->on('consultations');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('analyses', function (Blueprint $table) {
      //
    });
  }
};
