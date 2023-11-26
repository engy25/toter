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
        Schema::create('butlers', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('delivery_time');
            $table->decimal('delivery_charge',10,2);
            $table->decimal('service_charge',10,2);
            $table->bigInteger('admin_id')->unsigned()->default(1);
            $table->bigInteger('section_id')->unsigned()->default(15);
            $table->bigInteger('default_currency_id')->unsigned()->default(1);
            $table->decimal('exchange_rate', 10, 4);
            $table->bigInteger('to_currency_id')->unsigned();
            $table->foreign('default_currency_id')->references("id")->on("currencies")->onDelete('cascade');
            $table->foreign('to_currency_id')->references("id")->on("currencies")->onDelete('cascade');
            $table->foreign('admin_id')->references("id")->on("users")->onDelete('cascade');
            $table->foreign('section_id')->references("id")->on("sections")->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('butler_translations', function(Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->string('name');
          $table->string('description');
          $table->bigInteger('butler_id')->unsigned();
          $table->string('locale');
          $table->unique(['butler_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('butlers');
    }
};
