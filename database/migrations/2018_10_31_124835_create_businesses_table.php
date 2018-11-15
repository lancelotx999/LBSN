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
            $table->string('images');
            $table->boolean('verified');

            $table->timestamps();
        });

        DB::table('businesses')->insert(
        array(
            'owner_id' => "5bdfe2db84220c09e56acd44",
            'name' => "Cleaning Service",
            'description' => "We clean everything!",
            'services' => ["Cleaning","Sanitization"],
            'contact_number' => "012-5555555",
            'verified' => true,
        ));

        DB::table('businesses')->insert(
        array(
            'owner_id' => "5be58f6684220c1357418b43",
            'name' => "Curtains",
            'description' => "Everything related to curtains!",
            'services' => ["Installation","Cleaning","Creation"],
            'contact_number' => "012-5555555",
            'verified' => false,
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
