<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_name');
            $table->boolean('del_flg')->default(0);
            $table->integer('created');
            $table->integer('updated')->nullable();
        });


        // Insert some stuff
        DB::table('m_role')->insert(
            array(
                'role_name' => 'Admin',
                'created' => time()
            )
        );
        DB::table('m_role')->insert(
            array(
                'role_name' => 'Manage',
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
        Schema::dropIfExists('m_role');
    }
}
