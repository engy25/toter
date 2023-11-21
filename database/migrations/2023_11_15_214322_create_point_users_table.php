<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePointUsersTable extends Migration {

	public function up()
	{
		Schema::create('point_users', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unique()->unsigned();
			$table->bigInteger('pointeable_id')->unsigned();
			$table->string('pointeable_type');
			$table->integer('point_earned')->default('0');
			$table->integer('point_used')->default('0');
			$table->integer('point_expired')->default('0');
			$table->date('expired_at');
		});
	}

	public function down()
	{
		Schema::drop('point_users');
	}
}
