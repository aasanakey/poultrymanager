<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirdMortalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bird_mortality', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('batch_id');
            $table->unsignedBigInteger('farm_id');
            $table->string('pen_id');
            $table->integer('number');
            $table->string('cause');
            $table->string('observation')->nullable();
            $table->decimal('unit_price', 9, 2);
            $table->date('dod');
            $table->timestamps();
            $table->foreign('farm_id')->references('id')->on('farms')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('batch_id')->references('batch_id')->on('birds')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pen_id')->references('pen_id')->on('pen_houses')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bird_mortality');
    }
}