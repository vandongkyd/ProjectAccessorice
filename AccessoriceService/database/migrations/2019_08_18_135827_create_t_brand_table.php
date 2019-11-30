<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_brand', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand_name');
            $table->string('brand_img');
            $table->integer('brand_status')->default(0);
            $table->integer('discount_id')->nullable();
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
        Schema::dropIfExists('t_brand');
    }
}
