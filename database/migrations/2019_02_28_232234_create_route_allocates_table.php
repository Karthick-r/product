<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteAllocatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_allocates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id');
            $table->integer('district_id');
            $table->integer('state_id');
            $table->integer('zone_id');
            $table->integer('country_id');
            $table->integer('user_id');
            $table->integer('created_user');
            $table->integer('status');
            $table->string('date');  
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
        Schema::dropIfExists('route_allocates');
    }
}
