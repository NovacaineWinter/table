<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('table_id');
            $table->integer('time_start')->nullable();
            $table->integer('time_finish')->nullable();
            $table->integer('time_to_pay_for')->default(0);
            $table->decimal('cost')->nullable();
            $table->integer('base_hourly_rate')->nullable();  //in pence
            $table->boolean('been_transfered_to_till')->default(false);
            $table->boolean('been_paid')->default(false);
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
