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
            $table->decimal("service_charge",30,2)->nullable();
            $table->decimal("sum",30,2)->nullable();
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
