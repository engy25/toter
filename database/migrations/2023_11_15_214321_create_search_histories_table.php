<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSearchHistoriesTable extends Migration {

	public function up()
	{
		Schema::create('search_histories', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unsigned();
			$table->tinyInteger('is_active')->default('1');
			$table->string('keyword');
		});
	}

	public function down()
	{
		Schema::drop('search_histories');
	}
}
