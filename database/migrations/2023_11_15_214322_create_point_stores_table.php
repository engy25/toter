<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePointStoresTable extends Migration {

	public function up()
	{
		Schema::create('point_stores', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('store_id')->unique()->unsigned();
			$table->integer('order_counts')->default('0');
			$table->integer('expire_days')->default('1');
			$table->decimal('min_price', 10,2);
			$table->integer('points_earned')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('point_stores');
	}
}
