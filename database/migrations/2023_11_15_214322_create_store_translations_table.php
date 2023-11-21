<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('store_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('locale');
			$table->bigInteger('store_id')->unsigned();
      $table->unique(['store_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('store_translations');
	}
}
