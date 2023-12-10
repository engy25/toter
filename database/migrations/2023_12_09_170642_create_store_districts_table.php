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
        Schema::create('store_districts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("district_id")->unsigned();
            $table->foreign("district_id")->references("id")->on("districts")->onDelete("cascade");

            $table->bigInteger("store_id")->unsigned();
            $table->foreign("store_id")->references("id")->on("stores")->onDelete("cascade");
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
        Schema::dropIfExists('store_districts');
    }
};
