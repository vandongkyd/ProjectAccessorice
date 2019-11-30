<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no');
            $table->integer('purchase_date');
            $table->integer('delivery_date');
            $table->boolean('invoice_status')->default(0);
            $table->string('recipient_name')->nullable();
            $table->integer('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('payment_status')->default(0);
            $table->integer('customer_id');
            $table->integer('ship_id');
            $table->integer('type_delivery')->default(0);
            $table->string('discount_code')->nullable();
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
        Schema::dropIfExists('t_invoice');
    }
}
