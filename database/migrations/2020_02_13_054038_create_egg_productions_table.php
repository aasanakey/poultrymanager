<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEggProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egg_productions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('farm_id');
            $table->string('pen_id');
            $table->string('layer_batch_id');
            $table->string('bird_category');
            $table->date('date_collected');
            $table->integer('quantity');
            $table->integer('bad_eggs');
            $table->timestamps();
            $table->foreign('farm_id')->references('id')->on('farms')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('layer_batch_id')->references('batch_id')->onUpdate('cascade')->on('birds')->onDelete('cascade');
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
        Schema::dropIfExists('egg_productions');
    }
}