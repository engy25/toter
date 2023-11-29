<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('offer_id')->unsigned()->nullable();
			$table->bigInteger('driver_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->decimal('sub_total', 10,2);
			$table->decimal('total', 10,2);
			$table->decimal('delivery_charge', 10,2)->default('0');
			$table->decimal('service_charge', 10,2)->default('0');
			$table->string('payment_type')->default('cach');
			$table->string('transaction_id')->nullable();
			$table->bigInteger('default_currency_id')->unsigned()->default('1');
			$table->bigInteger('from_address')->unsigned()->nullable();
			$table->bigInteger('to_address')->unsigned()->nullable();
			$table->bigInteger('address_id')->unsigned()->nullable();
			$table->decimal('expected_cost', 10,2)->nullable();
			$table->text('from_driver_instructions')->nullable();
			$table->text('to_driver_instructions')->nullable();
			$table->integer('delivery_time')->nullable();
			$table->decimal('exchange_rate', 10,2);
			$table->bigInteger('coupon_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
