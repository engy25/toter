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
        Schema::create('delivery_arrival_times', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("delivery_id")->unsigned();
            $table->foreign("delivery_id")->references("id")->on("users")->onDelete("cascade");
            $table->bigInteger("day_id")->unsigned();
            $table->foreign("day_id")->references("id")->on("days")->onDelete("cascade");
            $table->integer("working_hours");
            $table->time("attendance_time");
            $table->time("cancel_time");
            $table->tinyInteger("is_cancel")->default(0);

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
        Schema::dropIfExists('delivery_arrival_times');
    }
};
