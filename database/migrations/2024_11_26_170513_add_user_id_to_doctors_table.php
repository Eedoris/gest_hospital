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
    Schema::table('doctors', function (Blueprint $table) {

      $table->string('specialty')->nullable();
      $table->timestamps();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('id_serv');
      $table->unsignedBigInteger('id_spe');


      $table->foreign('id_serv')->references('id_serv')->on('services');
      $table->foreign('id_spe')->references('id_spe')->on('specialities');

      $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('doctors', function (Blueprint $table) {
      $table->dropColumn('specialty');
      $table->dropForeign(['user_id']);
      $table->dropColumn('user_id');
      $table->dropColumn('id_serv');
      $table->dropColumn('id_spe');
    });
  }

};
