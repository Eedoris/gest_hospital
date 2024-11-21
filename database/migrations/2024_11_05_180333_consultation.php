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
    Schema::create('consultations', function (Blueprint $table) {
      $table->id('id_cons');
      $table->date('date_cons');
      $table->string('note');
     
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
