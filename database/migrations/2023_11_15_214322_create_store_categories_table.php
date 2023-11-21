<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('store_categories', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('store_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('store_categories');
	}
}
