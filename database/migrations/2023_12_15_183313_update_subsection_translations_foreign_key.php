<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('subsection_translations', function (Blueprint $table) {
        $table->dropForeign(['sub_section_id']);

        $table->foreign('sub_section_id')
            ->references('id')->on('subsections')
            ->onDelete('cascade');
    });

    Schema::table('offers', function (Blueprint $table) {
      $table->dropForeign(['subsection_id']);

      $table->foreign('subsection_id')
          ->references('id')->on('subsections')
          ->onDelete('cascade');
  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
