<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatingTicketingSupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chating_ticketing_support', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ticketing_support');
            $table->integer('sender')->nullable();
            $table->integer('reciver')->nullable();
            $table->text('messages')->nullable();
            $table->datetime('messages_send')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chating_ticketing_support');
    }
}
