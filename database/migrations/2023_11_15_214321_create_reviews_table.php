<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration {

	public function up()
	{
		Schema::create('reviews', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('user_id')->unsigned();
			$table->decimal('rating', 2,1);
			$table->string('comment')->nullable();
			$table->bigInteger('reviewable_id');
			$table->string('reviewable_type');
		});
	}

	public function down()
	{
		Schema::drop('reviews');
	}
}
