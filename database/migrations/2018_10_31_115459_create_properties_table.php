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

            $table->string('owner_id'); // ID of Owner
            $table->string('name');    // Name of Property
            $table->string('address'); // Address of Property
            $table->string('description'); // Description of Property
            $table->string('status'); // eg : Rent or Sale
            $table->string('tags'); // eg : Condo , single-storey

            $table->double('latitude'); // Location Data
            $table->double('longitude'); // Location Data

            $table->boolean('verified');

            $table->timestamps();
        });

        DB::table('properties')->insert(
        array(
            'owner_id' => "5bdfe2db84220c09e56acd43",
            'name' => "Room E555 @ Merdeka Palace",
            'address' => "123 Merdeka Hooha Lane",
            'description' => "Merdeka Palace Room",
            'status' => "Rent",
            'tags' => ["hotel","high-rise"],
            'latitude' => 321,
            'longitude' => 123,

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
        Schema::dropIfExists('properties');
    }
}
