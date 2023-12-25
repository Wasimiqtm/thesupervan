<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('product_views', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('product_id')->index()->unsigned();
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
                $table->string('ip',100)->nullable();
                $table->string('agent',100)->nullable();
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
        Schema::drop('product_views');
    }

}
