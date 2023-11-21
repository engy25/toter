<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('service_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('service_id')->unsigned();
			$table->string('locale');
      $table->unique(['service_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('service_translations');
	}
}
