<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWalletsTable extends Migration {

	public function up()
	{
		Schema::create('wallets', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('primary_currency_id')->unsigned();
			$table->decimal('primary_balance', 10,2)->default('0');
		});
	}

	public function down()
	{
		Schema::drop('wallets');
	}
}
