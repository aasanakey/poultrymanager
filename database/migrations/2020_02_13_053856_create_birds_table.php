<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('bird_category');
            $table->string('species');
            $table->string('type')->nullable();
            $table->decimal('unit_price',9,2);
            $table->timestamp('date');
            $table->timestamps();
            $table->primary(['batch_id','farm_id']);
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
        Schema::dropIfExists('birds');
    }
}
