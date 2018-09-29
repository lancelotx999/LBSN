<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('locationID');
            $table->string('locationOwnerID', 100);
            // $table->string('locationName', 100);
            // $table->string('locationAddress', 100);
            // $table->string('locationDescription', 255);
            // $table->string('locationStatus', 255);
            // $table->double('locationRating', 3, 2);
            // $table->double('locationLatitude', 10, 7);
            // $table->double('locationLongitude', 10, 7);
            $table->timestamps();
        });

        DB::table('locations')->insert(
        array(
            'locationOwnerID' => '1',
            'locationName' => 'Swinburne Sarawak University Hostel',
            'locationAddress' => 'Swinburne Sarawak University Hostel, Jalan Simpang Tiga, 93350 Kuching, Sarawak, Malaysia',
            'locationDescription' => 'Swinburne Sarawak University on campus hostel accomadation.',
            'locationStatus' => 'For Rent',
            'locationRating' => 2.5,
            'locationLongitude' => 1.5322626,
            'locationLatitude' => 110.3550372,
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
