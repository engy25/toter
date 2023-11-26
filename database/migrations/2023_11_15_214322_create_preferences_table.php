<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreferencesTable extends Migration {

	public function up()
	{
		Schema::create('preferences', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->decimal('price', 10,2)->default('0');
			$table->bigInteger('item_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('preferences');
	}
}
