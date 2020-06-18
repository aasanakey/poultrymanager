<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeatSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meat_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('farm_id');
            $table->date('date');
            $table->decimal('quantity');
            $table->decimal('price');
            $table->string('type');
            $table->string('part');
            $table->timestamps();
            $table->foreign('farm_id')->references('id')->on('farms')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meat_sales');
    }
}