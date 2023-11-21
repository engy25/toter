<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavouritesTable extends Migration {

	public function up()
	{
		Schema::create('favourites', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('favoriteable_id')->unsigned();
			$table->string('favoriteable_type');
			$table->bigInteger('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('favourites');
	}
}
