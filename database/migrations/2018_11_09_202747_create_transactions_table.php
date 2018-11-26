<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('merchant_id');
            $table->string('customer_id');
            $table->string('invoice_id');

            $table->string('payment_method');
            $table->double('amount_paid');
            $table->double('grand_total');

            $table->boolean('merchant_acknowledgement');
            $table->boolean('customer_acknowledgement');

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
        Schema::dropIfExists('transactions');
    }
}
