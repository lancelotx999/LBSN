<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_number');
            $table->string('role');
            $table->string('images');
            $table->boolean('verified');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'name' => "LBSN",
                'email' => "admin@LBSN.com",
                'password' => bcrypt("LBSN"),
                'role' => "admin",
                'verified' => true,
            ));

        DB::table('users')->insert(
            array(
                'name' => "Test_1",
                'email' => "test_1@LBSN.com",
                'password' => bcrypt("123"),
                'role' => "user",
                'verified' => false,
            ));

        DB::table('users')->insert(
            array(
                'name' => "Test_2",
                'email' => "test_2@LBSN.com",
                'password' => bcrypt("123"),
                'role' => "merchant",
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
        Schema::dropIfExists('users');
    }
}
