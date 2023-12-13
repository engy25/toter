<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->char('fname', 50)->nullable();
			$table->char('lname', 50)->nullable();
			$table->char('nickname')->nullable();
			$table->char('image', 100)->nullable();
			$table->date('dob')->nullable();
			$table->char('email', 60)->unique()->nullable();
			$table->char('phone', 50)->unique();
			$table->char('country_code', 10);
			$table->char('otp', 4)->nullable();
			$table->tinyInteger('is_active')->default('0');
			$table->char('updated_phone', 50)->nullable();
			$table->char('updated_country_code', 10)->nullable();
      $table->bigInteger('tier_id')->unsigned()->nullable();
			$table->integer('orders_count')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
