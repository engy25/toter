<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSideTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('side_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('side_id')->unsigned();
			$table->string('locale');
      $table->unique(['side_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('side_translations');
	}
}
