<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfferUsersTable extends Migration {

	public function up()
	{
		Schema::create('offer_users', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('offer_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->integer('order_count_of_user')->default('0');
			$table->date('expire_at');
		});
	}

	public function down()
	{
		Schema::drop('offer_users');
	}
}
