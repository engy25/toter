<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddonsTable extends Migration {

	public function up()
	{
		Schema::create('addons', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name');
			$table->string('image')->nullable();
			$table->decimal('price', 10,2)->default('0');
		});
	}

	public function down()
	{
		Schema::drop('addons');
	}
}
