<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCompanyAddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_company_add', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_itdp_profil_eks');
            $table->integer('id_event_detail')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('waktu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_company_add');
    }
}
