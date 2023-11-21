<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('store_id')->unique()->unsigned();
			$table->integer('discount_percentage')->nullable();
			$table->integer('order_counts')->default('1');
			$table->string('image');
			$table->decimal('min_price', 10,2);
			$table->integer('required_points');
			$table->bigInteger('tier_id')->unsigned()->default('1');
			$table->integer('earned_points')->default('0');
			$table->decimal('saveup_price', 10,2)->default('0');
			$table->integer('user_count')->default('10');
			$table->tinyInteger('free_delivery')->default('0');
			$table->date('from_date');
			$table->date('to_date');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
