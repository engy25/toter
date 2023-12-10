<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('order_butlers', function (Blueprint $table) {
      $table->id();
      $table->longText("order")->nullable();
      $table->bigInteger("butler_id")->unsigned()->nullable();
      $table->foreign("butler_id")->references("id")->on("butlers")->onDelete("cascade");

      $table->bigInteger("admin_id")->unsigned()->nullable();
      $table->foreign("admin_id")->references("id")->on("users")->onDelete("cascade");

      $table->string('delivery_time')->nullable();
      $table->bigInteger('driver_id')->unsigned()->nullable();
      $table->bigInteger('user_id')->unsigned();
      $table->bigInteger('from_address')->unsigned();
      $table->bigInteger('to_address')->unsigned();
      $table->text('from_driver_instructions')->nullable();
      $table->text('to_driver_instructions')->nullable();
      $table->decimal('sub_total', 30, 2);
      $table->decimal('total', 30, 2);
			$table->string('expected_cost')->nullable();
      $table->decimal('delivery_charge', 30, 2)->default('0');
      //$table->decimal('service_charge', 30, 2)->default('0');

			$table->bigInteger('coupon_id')->unsigned()->nullable();
      $table->foreign("coupon_id")->references("id")->on("coupons")->onDelete("cascade");

      $table->string('payment_type')->default('cach');
      $table->string('transaction_id')->nullable();
      $table->decimal('exchange_rate', 30, 2);
      $table->bigInteger("default_currency_id")->unsigned();
      $table->foreign("default_currency_id")->references("id")->on("currencies")->onDelete("cascade");
      $table->bigInteger("to_currency_id")->unsigned()->nullable();
      $table->foreign("to_currency_id")->references("id")->on("currencies")->onDelete("cascade");
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
    Schema::dropIfExists('order_butlers');
  }
};
