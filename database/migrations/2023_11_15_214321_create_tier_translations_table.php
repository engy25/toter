<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTierTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('tier_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('tier_id')->unsigned();
			$table->string('locale');
			$table->string('name');
			$table->string('description')->nullable();
      $table->unique(['tier_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('tier_translations');
	}
}
