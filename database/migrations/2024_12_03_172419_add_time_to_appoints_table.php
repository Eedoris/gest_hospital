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
      $table->time('time_app')->nullable()->after('date_app');
    });
  }

  public function down()
  {
    Schema::table('appoints', function (Blueprint $table) {
      $table->dropColumn('time_app');
    });
  }

};
