<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('wallet_transactions', function (Blueprint $table) {

      $table->bigInteger("currency_id")->unsigned()->default(1);
      $table->foreign("currency_id")->references("id")->on("currencies")->onDelete("cascade");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('wallet_transaction', function (Blueprint $table) {
      //
    });
  }
};
