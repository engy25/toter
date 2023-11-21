<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('option_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('option_id')->unique()->unsigned();
			$table->string('locle')->unique();
		});
	}

	public function down()
	{
		Schema::drop('option_translations');
	}
}
