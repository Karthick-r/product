<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('state_id');
            $table->integer('country_id');
            $table->string('name'); 
            $table->integer('shop_count')->default(0);
            $table->integer('status')->default(1);
            $table->integer('deleted_on_off')->default(1);
            $table->timestamp('deleted_at')->nullable();  
            $table->integer('created_user');   
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
        Schema::dropIfExists('routes');
    }
}
