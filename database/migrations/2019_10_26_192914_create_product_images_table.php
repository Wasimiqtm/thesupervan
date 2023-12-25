<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('product_images', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('product_id');
                $table->string('name');
                $table->enum('default',['1','0'])->default('0')->comment('1: Default Image');
		        $table->enum('is_active',['1','0'])->default('1');
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
        Schema::drop('product_images');
    }

}
