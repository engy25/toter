<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfferTanslationsTable extends Migration {

	public function up()
	{
		Schema::create('offer_tanslations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->bigInteger('offer_id')->unsigned();
			$table->string('locale');
      $table->unique(['offer_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::drop('offer_tanslations');
	}
}
