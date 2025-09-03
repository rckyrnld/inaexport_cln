<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscResearchCornerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_research_corner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en');
            $table->string('title_in');
            $table->integer('id_csc_research_type');
            $table->integer('id_mst_country');
            $table->integer('id_mst_hscodes');
            $table->text('exum');
            $table->timestamp('publish_date');
            $table->enum('upload_engine', ['Membership Engine', 'old'])->nullable();
            $table->integer('download')->nullable();
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csc_research_corner');
    }
}
