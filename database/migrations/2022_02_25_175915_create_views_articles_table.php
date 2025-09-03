<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('view_id');
            $table->string('view_type');
            $table->integer('user_id')->nullable();
            $table->ipAddress('visitor_ip');
            $table->text('agent');
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
        Schema::dropIfExists('views_articles');
    }
}
