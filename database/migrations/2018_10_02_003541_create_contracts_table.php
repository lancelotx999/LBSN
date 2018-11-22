<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('merchant_id');
            $table->string('customer_id');

            $table->string('item_id');
            $table->string('invoice_id');

            $table->string('type');
            $table->string('description');
            $table->double('price');

            $table->boolean('merchant_accepted');
            $table->boolean('customer_accepted');

            $table->boolean('paid_fully');
            $table->boolean('fulfilled');

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
        Schema::dropIfExists('contracts');
    }
}
