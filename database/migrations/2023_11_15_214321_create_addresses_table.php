<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	public function up()
	{
		Schema::create('addresses', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unsigned();
			$table->tinyInteger('default')->default('0');
			$table->string('building');
			$table->string('street');
			$table->string('apartment');
			$table->string('phone');
			$table->smallInteger('country_code');
			$table->string('instructions')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('addresses');
	}
}
