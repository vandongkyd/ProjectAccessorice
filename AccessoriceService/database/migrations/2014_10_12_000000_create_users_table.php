<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('user_name');
            $table->string('email');
            $table->integer('shop_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('language')->nullable()->default('en');
            $table->integer('gender')->default(0);
            $table->string('address')->nullable();
            $table->string('password');
            $table->integer('role_id');
            $table->integer('status')->nullable()->default(0);
            $table->integer('login_date')->nullable();
            $table->integer('password_status')->default(0);
            $table->boolean('lock_flg')->default(0);
            $table->boolean('del_flg')->default(0);
            $table->rememberToken();
            $table->integer('created');
            $table->integer('updated')->nullable();
        });

        // Insert some stuff
        DB::table('users')->insert(
            array(
                'last_name' => 'Admin',
                'first_name' => 'Admin',
                'user_name' => 'admin',
                'email' => 'admin@gmail.com',
                'avatar' => 'icon_men.png',
                'password' => bcrypt('password'),
                'role_id' => '1',
                'created' => time()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
