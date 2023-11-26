<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemAddonsTable extends Migration {

	public function up()
	{
		Schema::create('item_addons', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('item_id')->unsigned();
			$table->bigInteger('addon_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('item_addons');
	}
}
