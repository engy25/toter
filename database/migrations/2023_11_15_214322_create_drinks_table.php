<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDrinksTable extends Migration {

	public function up()
	{
		Schema::create('drinks', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('image')->nullable();
			$table->float('price');
		});
	}

	public function down()
	{
		Schema::drop('drinks');
	}
}
