<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItdpServiceEksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itdp_service_eks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_itdp_profil_eks');
            $table->string('nama_en')->nullable();
            $table->string('nama_ind')->nullable();
            $table->string('nama_chn')->nullable();
            $table->string('bidang_en')->nullable();
            $table->string('bidang_ind')->nullable();
            $table->string('bidang_chn')->nullable();
            $table->text('skill_en')->nullable();
            $table->text('skill_ind')->nullable();
            $table->text('skill_chn')->nullable();
            $table->text('pengalaman_en')->nullable();
            $table->text('pengalaman_ind')->nullable();
            $table->text('pengalaman_chn')->nullable();
            $table->text('link')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('itdp_service_eks');
    }
}
