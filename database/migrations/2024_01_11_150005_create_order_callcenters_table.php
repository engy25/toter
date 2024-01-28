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
        Schema::create('order_callcenters', function (Blueprint $table) {
          $table->id();
          $table->string("order_number", 191)->unique();
          $table->bigInteger('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->bigInteger('callcenter_id')->unsigned()->nullable();
          $table->foreign('callcenter_id')->references('id')->on('users')->onDelete('cascade');

          $table->bigInteger('vendor_id')->unsigned()->nullable();
          $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');

          $table->bigInteger('address_id')->unsigned()->nullable();
          $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');


          $table->decimal('sub_total', 30,2)->nullable();
          $table->decimal('total', 30,2)->nullable();
          $table->decimal('delivery_charge', 30,2)->default('0');
          $table->decimal('service_charge', 30,2)->default('0');
          $table->string('payment_type')->default('cach');
          $table->string('delivery_time')->nullable();

          $table->bigInteger('currency_id')->unsigned()->nullable();


          $table->bigInteger('delivery_id')->unsigned()->nullable();
          $table->foreign('delivery_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::dropIfExists('order_callcenters');
    }
};
