<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('currency_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('locale');
			$table->bigInteger('currency_id')->unsigned();
      $table->unique(['currency_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('currency_translations');
	}
}
