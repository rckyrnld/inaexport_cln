<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscChattingInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_chatting_inquiry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_inquiry')->nullable();
            $table->integer('sender')->nullable();
            $table->integer('receive')->nullable();
            $table->string('type')->nullable();
            $table->text('messages')->nullable();
            $table->text('file')->nullable();
            $table->integer('status')->nullable();
            $table->integer('id_broadcast_inquiry')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csc_chatting_inquiry');
    }
}
