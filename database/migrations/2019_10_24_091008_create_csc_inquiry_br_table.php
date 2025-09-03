<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscInquiryBrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_inquiry_br', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pembuat')->nullable();
            $table->string('type')->nullable();
            $table->integer('id_csc_prod_cat')->nullable();
            $table->integer('id_csc_prod_cat_level1')->nullable();
            $table->integer('id_csc_prod_cat_level2')->nullable();
            $table->string('jenis_perihal_en')->nullable();
            $table->string('jenis_perihal_in')->nullable();
            $table->string('jenis_perihal_chn')->nullable();
            $table->integer('id_mst_country')->nullable();
            $table->text('messages_en')->nullable();
            $table->text('messages_in')->nullable();
            $table->text('messages_chn')->nullable();
            $table->string('subyek_en')->nullable();
            $table->string('subyek_in')->nullable();
            $table->string('subyek_chn')->nullable();
            $table->integer('to')->nullable();
            $table->string('prodname')->nullable();
            $table->string('file')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('duration')->nullable();
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
        Schema::dropIfExists('csc_inquiry_br');
    }
}
