<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('batch_id')->unique();
            $table->unsignedBigInteger('farm_id');
            $table->string('number');
            $table->string('cause');
            $table->string('observation')->nullable();
            $table->decimal('unit_price',9,2);
            $table->timestamp('dod');
            $table->timestamps();
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('batch_id')->references('batch_id')->on('birds')->onDelete('cascade');
            $table->primary(['id','farm_id']);
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
