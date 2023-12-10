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
        Schema::table('offer_users', function (Blueprint $table) {
            //
            $table->tinyInteger("free_delivery")->default(0);
            $table->integer("point_earned",30)->default(0);
            $table->integer("point_used",30)->default(0);
            $table->integer("point_expired",30)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_users', function (Blueprint $table) {
            //
        });
    }
};
