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
      $table->string('state')->default('terminé');
      $table->string('result')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('analyses', function (Blueprint $table) {
      //
      $table->dropColumn('state');
      $table->dropColumn('result');
    });
  }
};
