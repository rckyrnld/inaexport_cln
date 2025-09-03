<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscInquiryBroadcastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_inquiry_broadcast', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_inquiry')->nullable();
            $table->integer('id_itdp_company_users')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('due_date')->nullable();
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
        Schema::dropIfExists('csc_inquiry_broadcast');
    }
}
