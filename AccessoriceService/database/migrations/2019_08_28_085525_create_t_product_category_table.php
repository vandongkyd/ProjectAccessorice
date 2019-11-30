<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_product_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_name');
            $table->integer('brand_id');
            $table->integer('discount_id')->nullable();
            $table->integer('category_status')->default(0);
            $table->integer('del_flg')->default(0);
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
        Schema::dropIfExists('t_product_category');
    }
}
