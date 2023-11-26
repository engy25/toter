<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemGiftsTable extends Migration {

	public function up()
	{
		Schema::create('item_gifts', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('item_id')->unsigned();
			$table->string('name');
			$table->string('image');
		});
	}

	public function down()
	{
		Schema::drop('item_gifts');
	}
}
