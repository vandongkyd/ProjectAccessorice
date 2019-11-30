<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_banner', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('banner_name');
            $table->string('banner_img');
            $table->integer('category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('sort_no');
            $table->text('banner_description')->nullable();
            $table->integer('banner_status')->default(0);
            $table->integer('banner_date_start')->nullable();
            $table->integer('banner_date_end')->nullable();
            $table->boolean('del_flg')->default(0);
            $table->integer('created');
            $table->integer('updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_banner');
    }
}
