<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderItemsTable extends Migration {

	public function up()
	{
		Schema::create('order_items', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('order_id')->unsigned();
			$table->bigInteger('item_id')->unsigned()->nullable();
			$table->bigInteger('size_id')->unsigned()->nullable();
			$table->text('options')->nullable();
			$table->text('drinks')->nullable();
			$table->text('sides')->nullable();
      $table->text('choose_days')->nullable();
			$table->decimal('price', 10,2);
			$table->integer('qty')->default('1');
			$table->decimal('total_price', 10,2)->default('1');
			$table->text('services')->nullable();
			$table->bigInteger('option_id')->unsigned()->nullable();
			$table->bigInteger('preference_id')->unsigned()->nullable();
			$table->text('notes')->nullable();
			$table->longText('order')->nullable();

		});
	}

	public function down()
	{
		Schema::drop('order_items');
	}
}
