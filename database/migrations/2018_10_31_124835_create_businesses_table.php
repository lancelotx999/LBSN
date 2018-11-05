<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('owner_id');
            $table->string('name');
            $table->string('description');
            $table->string('services');
            $table->string('contact_number');

            $table->boolean('verified');

            $table->timestamps();
        });

        DB::table('businesses')->insert(
        array(
            'owner_id' => "5bdfe2db84220c09e56acd44",
            'name' => "Cleaning Service",
            'description' => "We clean everything!",
            'services' => "Cleaning",
            'contact_number' => "012-5555555",
            'verified' => true,
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
