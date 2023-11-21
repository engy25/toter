<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionsTable extends Migration {

	public function up()
	{
		Schema::create('sections', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->softDeletes();
			$table->string('image');
		});
	}

	public function down()
	{
		Schema::drop('sections');
	}
}
