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
            $table->string('providerID'); // use id from User
            $table->string('receiverID'); // use id from User
            $table->string('LocationID'); // use id from Location
            $table->string('contractType');
            $table->string('contractContent');
            $table->decimal('contractValue');
            $table->string('contractStatus');
            $table->string('providerSignature'); // use User password to sign for now
            $table->string('receiverSignature'); // use User password to sign for now
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
