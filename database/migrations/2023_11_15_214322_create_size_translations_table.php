<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSizeTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('size_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('size_id')->unsigned();
			$table->string('locale');
      $table->unique(['size_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('size_translations');
	}
}
