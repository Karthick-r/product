<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');  
            $table->text('description',1000)->nullable();
            $table->text('image',1000)->nullable();
            $table->integer('quantity');
            $table->integer('unit_id');
            $table->string('cat_id');
            $table->string('price');
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
        Schema::dropIfExists('products');
    }
}
