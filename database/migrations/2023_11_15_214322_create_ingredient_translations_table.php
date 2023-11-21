<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngredientTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('ingredient_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('ingredient_id')->unsigned();
			$table->string('locale');
      $table->unique(['ingredient_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('ingredient_translations');
	}
}
