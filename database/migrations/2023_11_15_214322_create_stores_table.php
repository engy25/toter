<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoresTable extends Migration {

	public function up()
	{
		Schema::create('stores', function(Blueprint $table) {
      $table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('default_currency_id')->unsigned()->default(1);
			$table->decimal('price', 10,2)->nullable();
      $table->decimal('exchange_rate', 10, 4);
			$table->bigInteger('to_currency_id')->unsigned();
			$table->string('image');
			// $table->time('from_hour');
			// $table->time('to_hour');
			$table->text('address')->nullable();
			$table->double('lat');
			$table->double('lng');
			$table->integer('delivery_time');
			$table->float('delivery_fees');
      $table->decimal('avg_rating', 3, 2)->default('0');
			$table->tinyInteger('is_offered')->default('0');
			$table->bigInteger('admin_id')->unsigned();
			$table->bigInteger('sub_section_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('stores');
	}
}
