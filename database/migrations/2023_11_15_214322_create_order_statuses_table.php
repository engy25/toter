<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderStatusesTable extends Migration {

	public function up()
	{
		Schema::create('order_statuses', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
		
			$table->bigInteger('status_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('order_statuses');
	}
}
