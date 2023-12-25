<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function(Blueprint $table) {
                $table->increments('id');                     
                $table->enum('type',['1','2'])->default('1')->comment('Html: 1, Image: 0');
                $table->longText('html')->nullable();
                $table->string('image')->nullable();
                $table->integer('ordering')->nullable()->default(0); 
                $table->enum('status',['0','1'])->default('1')->comment('Active: 1, Iactive: 0');
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
        Schema::drop('sliders');
    }
}
