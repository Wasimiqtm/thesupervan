<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->index()->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->bigInteger('product_id')->index()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');  
            $table->bigInteger('order_id')->default(0)->nullable();
            $table->bigInteger('user_id')->default(0)->nullable();
            $table->string('stock_type',10)->default(null)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('origin',30)->default(null)->nullable();
            $table->text('note')->default(null)->nullable();
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
        Schema::drop('stock_history');
    }
}
