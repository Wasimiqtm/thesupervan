<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
                $table->bigIncrements('id');  
                $table->bigInteger('store_id')->index()->unsigned();
                $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
                $table->bigInteger('parent_id');               
                $table->string('prefix');
                $table->string('name');
                $table->string('image')->nullable()->default('NULL');
                $table->integer('ordering')->nullable()->default(0); 
                $table->enum('is_active',['active','inactive'])->default('active');
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
        Schema::drop('categories');
    }
}
