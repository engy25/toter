<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDrinkTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('drink_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->char('name', 50);
			$table->bigInteger('drink_id')->unsigned();
			$table->string('locale');
      $table->unique(['drink_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('drink_translations');
	}
}
