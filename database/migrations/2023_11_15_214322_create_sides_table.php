<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSidesTable extends Migration {

	public function up()
	{
		Schema::create('sides', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->decimal('price', 10,2)->default('0');
			$table->string('image');
			$table->bigInteger('item_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('sides');
	}
}
