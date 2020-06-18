<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirdcategoryToBirdsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('bird_sales', function (Blueprint $table) {
        //     $table->string('bird_category');
        //     $table->integer('number');

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bird_sales', function (Blueprint $table) {
            Schema::dropIfExists(['bird_category', 'number']);
        });
    }
}