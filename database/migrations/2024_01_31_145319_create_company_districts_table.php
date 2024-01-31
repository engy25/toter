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
        Schema::create('company_districts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_id')->unsigned()->nullable();
            $table->foreign('from_id')->references('id')->on('districts')->onDelete('cascade');

            $table->bigInteger('to_id')->unsigned()->nullable();
            $table->foreign('to_id')->references('id')->on('districts')->onDelete('cascade');
            $table->decimal("delivery_charge",30,2);
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
        Schema::dropIfExists('company_districts');
    }
};
