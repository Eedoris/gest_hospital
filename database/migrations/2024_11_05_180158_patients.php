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
    Schema::create('patients', function (Blueprint $table) {
      $table->id('id_pat');
      $table->string('name');
      $table->string('surname');
      $table->date('date_of_birth');
      $table->string('sex');
      $table->string('adress');
      $table->string('contact');
      $table->uuid('uuid')->unique();
      $table->timestamps();
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
