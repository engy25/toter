<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiers', function (Blueprint $table) {
            // $table->integer('extra_point_percentage')->default(0);
            // $table->decimal('price', 10, 2);
            // $table->bigInteger('currency_id')->unsigned();


            // $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict')
						// ->onUpdate('restrict');
        });

        Schema::table('stores', function (Blueprint $table) {
            // $table->tinyInteger('is_earn_point')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiers', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn('extra_point_percentage');
            $table->dropColumn('price');
            $table->dropColumn('currency_id');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('is_earn_point');
        });
    }
}
