<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pen_houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pen_id')->unique();
            $table->unsignedBigInteger('farm_id');
            $table->string('location');
            $table->decimal('size', 10, 2);
            $table->integer('capacity');
            $table->string('bird_type');
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
        Schema::dropIfExists('pen_houses');
    }
}