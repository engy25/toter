<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration {

	public function up()
	{
		Schema::create('devices', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->text('device_token');
			$table->enum('type', array('ios', 'android'));
			$table->bigInteger('user_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('devices');
	}
}
