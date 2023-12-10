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
        Schema::create('order_butler_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id")->unsigned();
            $table->foreign("order_id")->references("id")->on("order_butlers")->onDelete("cascade");
            $table->text("item");
            $table->string("image")->nullable();
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
        Schema::dropIfExists('order_butler_items');
    }
};
