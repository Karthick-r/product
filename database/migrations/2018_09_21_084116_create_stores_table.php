<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_name');  
            $table->string('store_phone')->unique(); 
            $table->string('store_email')->nullable(); 
            $table->string('contact_person')->nullable(); 
            $table->text('image',1000)->nullable();
            $table->text('mobile',1000)->nullable();
            $table->string('gst_id')->nullable(); 
            $table->text('address',2000)->nullable(); 
            $table->integer('pincode')->nullable();  
            $table->string('latitude');  
            $table->string('longitude');
            $table->integer('route_id');
            $table->string('district_id'); 
            $table->string('zone_id'); 
            $table->string('state_id'); 
            $table->string('country_id'); 
            $table->integer('createdby_user_id');
            $table->integer('category');  
            $table->text('remark')->nullable();
            $table->integer('status')->default(1);
            $table->integer('deleted_on_off')->default(1);
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
