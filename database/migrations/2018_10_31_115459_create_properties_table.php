<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');

            $table->string('owner_id'); 
            $table->string('name');   
            $table->string('address'); 
            $table->string('description'); 
            $table->string('menu'); 
            $table->string('tags'); 
            $table->string('images');
            $table->double('latitude'); 
            $table->double('longitude'); 

            $table->boolean('verified');

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
        Schema::dropIfExists('properties');
    }
}
