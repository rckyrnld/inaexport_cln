<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level_1')->nullable();
            $table->integer('level_2')->nullable();
            $table->string('nama_kategori_en');
            $table->string('nama_kategori_in')->nullable();
            $table->string('nama_kategori_chn')->nullable();
            $table->enum('type', ['main product', 'persepctive product'])->nullable();
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
        Schema::dropIfExists('csc_product');
    }
}
