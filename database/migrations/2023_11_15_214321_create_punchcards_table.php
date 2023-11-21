<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePunchcardsTable extends Migration {

	public function up()
	{
		Schema::create('punchcards', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('punchcards');
	}
}
