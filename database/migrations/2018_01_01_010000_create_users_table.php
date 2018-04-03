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
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role_id');
            $table->string('img_raw')->default('/img/defaultUserImg.png');
            $table->string('addr_line_one',500);
            $table->string('addr_line_two',500);
            $table->string('town',500);
            $table->string('county',50);
            $table->string('postcode',50);
            $table->string('phone',20);
            $table->boolean('currently_playing')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
