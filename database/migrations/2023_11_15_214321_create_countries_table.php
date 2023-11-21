<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('flag');
			$table->bigInteger('currency_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('countries');
	}
}
