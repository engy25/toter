<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSizesTable extends Migration {

	public function up()
	{
		Schema::create('sizes', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('item_id')->unsigned();
			$table->decimal('price', 10,2)->default('0');
		});
	}

	public function down()
	{
		Schema::drop('sizes');
	}
}
