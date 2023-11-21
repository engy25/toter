<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreferenceTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('preference_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('preference_id')->unsigned();
			$table->string('locale');
      $table->unique(['preference_id', 'locale']);
			$table->string('name');
		});
	}

	public function down()
	{
		Schema::drop('preference_translations');
	}
}
