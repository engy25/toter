<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreCategoryTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('store_category_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->bigInteger('store_category_id')->unsigned();
			$table->string('locale');
      $table->unique(['store_category_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('store_category_translations');
	}
}
