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
      Schema::table('order_butlers', function (Blueprint $table) {
        //
        $table->bigInteger('district_id')->unsigned()->nullable();
        $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_butlers', function (Blueprint $table) {
            //
        });
    }
};
