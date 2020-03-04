<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('layer_batch_id');
            // $table->string('pen_id');
            $table->timestamp('date_collected');
            $table->integer('qunatity');
            $table->timestamps();
            $table->primary(['id','farm_id']);
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('layer_batch_id')->references('batch_id')->on('birds')->onDelete('cascade');
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
