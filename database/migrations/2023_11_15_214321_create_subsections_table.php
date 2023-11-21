<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubsectionsTable extends Migration {

	public function up()
	{
		Schema::create('subsections', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('section_id')->unsigned()->default('0');
			$table->string('image');
		});
	}

	public function down()
	{
		Schema::drop('subsections');
	}
}
