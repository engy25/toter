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
    Schema::table('drinks', function (Blueprint $table) {

      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

    Schema::table('addons', function (Blueprint $table) {
      //
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

    Schema::table('services', function (Blueprint $table) {
      //
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

    Schema::table('options', function (Blueprint $table) {
      //
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

    Schema::table('sides', function (Blueprint $table) {
      //
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });



    Schema::table('ingredients', function (Blueprint $table) {
      //
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

    Schema::table('preferences', function (Blueprint $table) {
      //
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

    Schema::table('sizes', function (Blueprint $table) {
      $table->bigInteger("store_id")->unsigned()->default(1);
      $table->foreign("store_id")->references("id")->on("stores")->onDelete('cascade');
    });

  }


  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('drinks', function (Blueprint $table) {
      //
    });
  }
};
