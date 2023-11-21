<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubsectionTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('subsection_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('sub_section_id')->unsigned();
			$table->string('locale');
			$table->string('name');
			$table->text('description');
      $table->unique(['sub_section_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('subsection_translations');
	}
}
