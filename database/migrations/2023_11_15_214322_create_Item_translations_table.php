<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('Item_translations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->bigInteger('item_id')->unsigned();
			$table->string('locale');
      $table->unique(['item_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('Item_translations');
	}
}
