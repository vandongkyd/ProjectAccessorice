<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('discount_name');
            $table->string('percent_reduction')->nullable();
            $table->string('gift_code')->nullable();
            $table->integer('discount_status')->default(0);
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
        Schema::dropIfExists('t_discount');
    }
}
