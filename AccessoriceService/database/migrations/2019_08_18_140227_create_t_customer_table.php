<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('user_name');
            $table->string('email');
            $table->integer('gender')->default(0);
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('language')->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->integer('birthday')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('login_date')->nullable();
            $table->boolean('lock_flg')->default(0);
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
        Schema::dropIfExists('t_customer');
    }
}
