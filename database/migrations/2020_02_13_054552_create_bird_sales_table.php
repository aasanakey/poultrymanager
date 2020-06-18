<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirdSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bird_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('farm_id');
            $table->string('bird_batch_id');
            $table->date('date');
            $table->decimal('weight');
            $table->decimal('price');
            $table->string('bird_category');
            $table->integer('number');
            $table->timestamps();
            $table->foreign('farm_id')->references('id')->on('farms')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('bird_batch_id')->references('batch_id')->on('birds')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bird_sales');
    }
}