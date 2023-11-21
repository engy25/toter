<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatusTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('status_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('locale');
			$table->string('name');
			$table->text('description')->nullable();
			$table->bigInteger('status_id')->unsigned();
      $table->unique(['status_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('status_translations');
	}
}
