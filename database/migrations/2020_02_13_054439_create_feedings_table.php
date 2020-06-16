<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('farm_id');
            $table->string('pen_id');
            $table->timestamp('date');
            $table->unsignedBigInteger('feed_id');
            $table->decimal('feed_quantity');
            $table->decimal('water_quantity');
            $table->timestamps();
            $table->foreign('pen_id')->references('pen_id')->on('pen_houses')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('feedings');
    }
}