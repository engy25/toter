<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponsTable extends Migration {

	public function up()
	{
		Schema::create('coupons', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('store_id')->unsigned()->nullable();
			$table->string('code');
			$table->integer('discount_percentage');
			$table->date('expire_date');
			$table->tinyInteger('is_active')->default('1');
		});
	}

	public function down()
	{
		Schema::drop('coupons');
	}
}
