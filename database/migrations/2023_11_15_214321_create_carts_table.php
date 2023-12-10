<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	public function up()
	{
		Schema::create('carts', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('item_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('size_id')->unsigned()->nullable();
			$table->integer('qty')->default('1');
			$table->bigInteger('preference_id')->unsigned()->nullable();
			$table->bigInteger('option_id')->unsigned()->nullable();
			$table->text('notes')->nullable();
			$table->bigInteger('gift_id')->unsigned()->nullable();

		});
	}

	public function down()
	{
		Schema::drop('carts');
	}
}
