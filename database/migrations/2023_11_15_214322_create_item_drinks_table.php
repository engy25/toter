<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemDrinksTable extends Migration {

	public function up()
	{
		Schema::create('item_drinks', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->bigInteger('item_id')->unique()->unsigned();
			$table->bigInteger('drink_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('item_drinks');
	}
}
