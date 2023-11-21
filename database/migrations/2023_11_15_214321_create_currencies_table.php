<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	public function up()
	{
		Schema::create('currencies', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('isocode')->unique();
			$table->tinyInteger('default')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('currencies');
	}
}
