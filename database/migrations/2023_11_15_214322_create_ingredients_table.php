<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngredientsTable extends Migration {

	public function up()
	{
		Schema::create('ingredients', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('image');
			$table->bigInteger('item_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('ingredients');
	}
}
