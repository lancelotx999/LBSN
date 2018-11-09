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

            $table->string('provider_id');
            $table->string('receiver_id');

            $table->string('item_id');

            $table->string('type');
            $table->string('description');
            $table->double('price');

            $table->boolean('accepted');
            $table->boolean('fulfilled');

            $table->timestamps();
        });

            DB::table('contracts')->insert(
        array(
            'provider_id' => "5bdfe2db84220c09e56acd44",
            'receiver_id' => "5bdfe2db84220c09e56acd43",
            'item_id' => "5bdfeb6884220c0f7f0d803b",
            'type' => "Service",
            'description' => "Cleaning receiver's property",
            'price' => 100.5,

            'accepted' => false,
            'fulfilled' => false,
        ));


            DB::table('contracts')->insert(
        array(
            'provider_id' => "5bdfe2db84220c09e56acd44",
            'receiver_id' => "5bdfe2db84220c09e56acd43",
            'item_id' => "5bdfeb6884220c0f7f0d803b",
            'type' => "Service",
            'description' => "Cleaning receiver's property AGAIN",
            'price' => 200.5,

            'accepted' => true,
            'fulfilled' => false,
        ));            

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
