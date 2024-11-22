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
    Schema::create('users', function (Blueprint $table) {
      $table->id('id_user');
      $table->string('name');
      $table->string('surname');
      $table->string('email')->unique();
      $table->string('password');
      $table->string('statut');
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
