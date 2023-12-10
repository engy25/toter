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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("sender_id")->unsigned();
            $table->foreign("sender_id")->references("id")->on("users")->onDelete("cascade");

            $table->bigInteger("receiver_id")->unsigned();
            $table->foreign("receiver_id")->references("id")->on("users")->onDelete("cascade");

            $table->string("transaction_type");
            $table->decimal("amount",23,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
