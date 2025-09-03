<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('event_name_en')->nullable();
            $table->string('event_name_in')->nullable();
            $table->string('event_name_chn')->nullable();
            $table->string('event_type_en')->nullable();
            $table->string('event_type_in')->nullable();
            $table->string('event_type_chn')->nullable();
            $table->char('id_event_organizer')->nullable();
            $table->text('event_organizer_text_en')->nullable();
            $table->text('even_organizer_text_in')->nullable();
            $table->text('even_organizer_text_chn')->nullable();
            $table->char('id_event_place')->nullable();
            $table->text('event_place_text_en')->nullable();
            $table->text('event_place_text_in')->nullable();
            $table->text('event_place_text_chn')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->text('website')->nullable();
            $table->string('jenis_en')->nullable();
            $table->string('jenis_in')->nullable();
            $table->string('jenis_chn')->nullable();
            $table->integer('event_comodity')->nullable();
            $table->string('event_scope_en')->nullable();
            $table->string('event_scope_in')->nullable();
            $table->string('event_scope_chn')->nullable();
            $table->integer('id_prod_cat')->nullable();
            $table->char('id_articles')->nullable();
            $table->integer('id_prod_sub1_kat')->nullable();
            $table->integer('id_prod_sub2_kat')->nullable();
            $table->string('status_en')->nullable();
            $table->string('status_in')->nullable();
            $table->string('status_chn')->nullable();
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
        Schema::dropIfExists('event_detail');
    }
}
