<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('country_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->char('locale');
			$table->bigInteger('country_id')->unsigned();
      $table->unique(['country_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('country_translations');
	}
}
