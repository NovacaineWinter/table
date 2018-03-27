<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            
            //basic data
            $table->increments('id');
            $table->integer('type_id');
            $table->integer('number');
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(true);

            //to do with current state of affairs
            $table->boolean('is_occupied')->default(false);
            $table->integer('current_booking_id')->nullable();
            
            //to do with time logging for the table
            $table->integer('time_since_clean')->default(0);
            $table->integer('time_since_recloth')->default(0);
            $table->integer('time_since_recushion')->default(0);
            $table->integer('time_total')->default(0);

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
        Schema::dropIfExists('tables');
    }
}
