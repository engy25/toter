<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_butler_statuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("status_id")->unsigned();
            $table->foreign("status_id")->references("id")->on("statuses")->onDelete("cascade");
            $table->bigInteger("order_id")->unsigned();
            $table->foreign("order_id")->references("id")->on("order_butlers")->onDelete("cascade");
            $table->timestamps();
        });

        Schema::table('order_butlers', function (Blueprint $table) {
          $table->bigInteger("status_id")->unsigned()->default(1);
          $table->foreign("status_id")->references("id")->on("statuses")->onDelete("cascade");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_butler_statuses');
    }
};
