<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('title');
			$table->string('data');
			$table->bigInteger('user_id')->unsigned();
			$table->tinyInteger('is_read')->default('0');
			$table->timestamp('read_at')->nullable();
			$table->string('notifiable_type')->index();
			$table->bigInteger('notifiable_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
