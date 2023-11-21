<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends Migration {

	public function up()
	{
		Schema::create('providers', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unique()->unsigned();
			$table->char('provider');
			$table->string('provider_id');
		});
	}

	public function down()
	{
		Schema::drop('providers');
	}
}
