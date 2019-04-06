<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id'); 
            $table->string('store_id'); 
            $table->string('route_id'); 
            $table->string('date');  
            $table->string('time');
            $table->string('latitude');  
            $table->string('longitude'); 
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
        Schema::dropIfExists('store_attendances');
    }
}
