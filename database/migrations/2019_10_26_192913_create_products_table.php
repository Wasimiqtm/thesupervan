<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('products', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->default(0)->nullable();
            $table->string('name');
            $table->string('code',100);
            $table->string('sku',100);
            $table->bigInteger('supplier_id')->default(0)->nullable();
            $table->bigInteger('shipping_id')->default(0)->nullable();
            $table->bigInteger('brand_id')->index()->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->bigInteger('tax_rate_id')->index()->unsigned();
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade');
            $table->string('barcode_symbology',10)->nullable();
            $table->string('cost',100)->nullable(true);
            $table->string('price',100);
            $table->tinyInteger('is_variants')->default(0)->comment('Yes: 1, No: 0');
            $table->enum('discount_type',['0','1','2'])->default('0')->comment('Percentage: 1, Fixed: 2');
            $table->integer('discount')->default(0);            
            $table->enum('tax_method',['1','2'])->default('1')->comment('Exclusive: 1, Inclusive: 2');
            $table->tinyInteger('is_default')->default(0)->comment('Yes: 1, No: 0');
            $table->tinyInteger('is_main_price')->default(0)->comment('Yes: 1, No: 0');
            $table->tinyInteger('is_main_tax')->default(0)->comment('Yes: 1, No: 0');
            $table->text('detail')->nullable(true);
            $table->text('invoice_detail')->nullable(true);
            $table->longText('full_detail')->nullable(true);
            $table->longText('tecnical_specs')->nullable(true);
            $table->enum('new_arrivals',['0','1'])->default('0')->comment('Yes: 1, No: 0');
            $table->enum('is_featured',['0','1'])->default('0')->comment('Yes: 1, No: 0');
            $table->enum('is_hot',['0','1'])->default('0')->comment('Yes: 1, No: 0');
            $table->enum('is_active',['0','1'])->default('1')->comment('Active: 1, Iactive: 0');
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
        Schema::drop('products');
    }

}
