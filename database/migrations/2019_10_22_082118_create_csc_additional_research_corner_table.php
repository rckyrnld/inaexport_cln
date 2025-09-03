<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscAdditionalResearchCornerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_additional_research_corner', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_research_corner');
            $table->integer('id_itdp_profil_eks');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csc_additional_research_corner');
    }
}
