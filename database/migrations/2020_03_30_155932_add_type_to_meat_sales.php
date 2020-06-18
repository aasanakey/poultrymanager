<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToMeatSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meat_sales', function (Blueprint $table) {
            // $table->string('type');
            // $table->string('part');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meat_sales', function (Blueprint $table) {
            Schema::dropIfExists(['type', 'part']);

        });
    }
}