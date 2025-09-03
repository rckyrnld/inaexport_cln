<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('training_en')->nullable();
            $table->string('training_in')->nullable();
            $table->string('training_chn')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('param')->nullable();
            $table->string('topic_en')->nullable();
            $table->string('topic_in')->nullable();
            $table->string('topic_chn')->nullable();
            $table->text('location_en')->nullable();
            $table->text('location_in')->nullable();
            $table->text('location_chn')->nullable();
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
        Schema::dropIfExists('training_admin');
    }
}
