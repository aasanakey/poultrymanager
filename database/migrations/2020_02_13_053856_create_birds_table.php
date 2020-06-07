<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birds', function (Blueprint $table) {
            $table->string('batch_id')->unique();
            $table->unsignedBigInteger('farm_id');
            $table->string('pen_id');
            $table->string('bird_category');
            $table->integer('number');
            $table->string('species');
            $table->string('type')->nullable();
            $table->decimal('unit_price', 9, 2);
            $table->date('date');
            $table->timestamps();
            $table->primary(['batch_id', 'farm_id']);
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('pen_id')->references('pen_id')->on('pen_houses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birds');
    }
}