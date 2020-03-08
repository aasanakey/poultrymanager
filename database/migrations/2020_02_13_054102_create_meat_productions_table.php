<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeatProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meat_productions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('farm_id');
            $table->string('layer_batch_id');
            $table->timestamp('date_slaughtered');
            $table->integer('quantity');
            $table->decimal('bird_avg_weight');
            $table->decimal('cacass_avg_weight');
            $table->timestamps();
            // $table->primary(['id','farm_id']);
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
        Schema::dropIfExists('meat_productions');
    }
}
