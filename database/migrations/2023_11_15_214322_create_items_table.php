<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('category_id')->unsigned()->default('0');
			$table->bigInteger('store_id')->unsigned();
			$table->string('image');
			$table->decimal('price', 30,2);
			$table->bigInteger('default_currency_id')->unsigned();
			$table->tinyInteger('has_gift')->default('0');
			$table->bigInteger('has_offer')->default('0');
			$table->bigInteger('is_restaurant')->default('0');
      $table->integer('choose_days')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('items');
	}
}
