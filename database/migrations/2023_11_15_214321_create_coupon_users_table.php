<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponUsersTable extends Migration {

	public function up()
	{
		Schema::create('coupon_users', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('coupon_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('coupon_users');
	}
}
