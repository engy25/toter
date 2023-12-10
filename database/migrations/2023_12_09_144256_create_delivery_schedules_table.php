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
        Schema::create('delivery_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("day_id")->unsigned();
            $table->foreign("day_id")->references("id")->on("days")->onDelete("cascade");

            $table->bigInteger("delivery_id")->unsigned();
            $table->foreign("delivery_id")->references("id")->on("users")->onDelete("cascade");

            $table->integer("working_hours");
            $table->time("from_time");
            $table->time("to_time")->nullable();

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
        Schema::dropIfExists('delivery_schedules');
    }
};
