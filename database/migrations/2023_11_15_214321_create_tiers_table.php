<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiersTable extends Migration {

	public function up()
	{
		Schema::create('tiers', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('orders_count')->nullable();
			$table->integer('duration_bydays')->default('30');
			$table->integer('expired_duration_bydays',30)->default('90');
			$table->integer('earn_reward_point',30);
      $table->string('image')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('tiers');
	}
}
