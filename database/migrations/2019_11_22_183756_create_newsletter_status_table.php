<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('newsletter_id');
            $table->integer('subscriber_id');
            $table->string('status');
            $table->dateTime('send_time')->nullable();
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
        Schema::dropIfExists('newsletter_status');
    }
}
