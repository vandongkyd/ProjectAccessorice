<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('category_id');
            $table->double('product_price');
            $table->integer('product_quality');
            $table->text('product_description')->nullable();
            $table->text('product_detail')->nullable();
            $table->integer('product_status')->default(0);
            $table->integer('product_ratting')->nullable();
            $table->integer('discount_id')->nullable();
            $table->integer('product_date_start')->nullable();
            $table->integer('product_date_end')->nullable();
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
        Schema::dropIfExists('t_product');
    }
}
