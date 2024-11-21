<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('appoints', function (Blueprint $table) {
      $table->string('state')->nullable()->change();
      $table->string('reason')->nullable()->change();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down()
  {
    Schema::table('appoints', function (Blueprint $table) {
      $table->string('state')->nullable(false)->change();
      $table->string('reason')->nullable(false)->change(); 
    });
  }
};
