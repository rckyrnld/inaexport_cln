<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblDownloadCurris extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_download_curris', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_itdp_profil_eks');
            $table->integer('id_curris');
            $table->integer('id_mst_country')->nullable();
            $table->timestamp('waktu');
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_download_curris');
    }
}
