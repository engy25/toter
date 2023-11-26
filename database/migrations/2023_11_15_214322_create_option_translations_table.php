<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('option_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('option_id')->unsigned();
			$table->string('locale');
      $table->unique(['option_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('option_translations');
	}
}
