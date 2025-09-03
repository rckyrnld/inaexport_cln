<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSupp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_support', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->timestamp('date')->nullable();
            $table->text('subject')->nullable();
            $table->text('email')->nullable();
            $table->text('desc')->nullable();
            $table->text('fileq')->nullable();
            $table->text('answer')->nullable();
            $table->text('filean')->nullable();
            $table->integer('status')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_support');
    }
}
