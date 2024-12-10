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
    Schema::table('appoints', function (Blueprint $table) {
      $table->enum('status', ['Prévu', 'Effectué', 'Annulé', 'Reprogrammé'])->default('Prévu');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('appoints', function (Blueprint $table) {
      //
    });
  }
};
