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
      Schema::create('deliveries', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('ordereable_id')->unsigned();
        $table->string('ordereable_type');
        $table->bigInteger('delivery_id')->unsigned()->nullable();
        $table->foreign('delivery_id')->references('id')->on('users')->onDelete('cascade');
        $table->double("lat")->nullable();
        $table->double("lng")->nullable();
        $table->bigInteger('status_id')->unsigned()->nullable();
        $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};
