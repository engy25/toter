<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('section_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->text('description');
			$table->bigInteger('section_id')->unsigned();
			$table->string('locale');
      $table->unique(['section_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('section_translations');
	}
}
