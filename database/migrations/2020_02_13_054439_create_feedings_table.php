<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->primary(['id','farm_id']);
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
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
