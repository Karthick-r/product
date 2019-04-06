<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('date');  
            $table->string('time');     
            $table->string('punch')->default(0);       
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
        Schema::dropIfExists('day_attendances');
    }
}
