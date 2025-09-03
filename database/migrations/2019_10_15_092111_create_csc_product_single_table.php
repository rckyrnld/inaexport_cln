<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCscProductSingleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csc_product_single', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_csc_product')->nullable();
            $table->integer('id_csc_product_level1')->nullable();
            $table->integer('id_csc_product_level2')->nullable();
            $table->string('prodname_en')->nullable();
            $table->string('prodname_in')->nullable();
            $table->string('prodname_chn')->nullable();
            $table->string('code_en')->nullable();
            $table->string('code_in')->nullable();
            $table->string('code_chn')->nullable();
            $table->string('color_en')->nullable();
            $table->string('color_in')->nullable();
            $table->string('color_chn')->nullable();
            $table->string('size_en')->nullable();
            $table->string('size_in')->nullable();
            $table->string('size_chn')->nullable();
            $table->string('raw_material_en')->nullable();
            $table->string('raw_material_in')->nullable();
            $table->string('raw_material_chn')->nullable();
            $table->string('capacity')->nullable();
            $table->string('price_usd')->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_4')->nullable();
            $table->integer('id_itdp_profil_eks')->nullable();
            $table->integer('id_itdp_company_user')->nullable();
            $table->string('minimum_order')->nullable();
            $table->text('product_description_en')->nullable();
            $table->text('product_description_in')->nullable();
            $table->text('product_description_chn')->nullable();
            $table->integer('status')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('csc_product_single');
    }
}
