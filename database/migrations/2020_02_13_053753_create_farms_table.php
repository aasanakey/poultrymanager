<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("farm_name" );
            $table->string("farm_email");
            $table->string("farm_location");
            $table->string("farm_contact");
            $table->string("farm_manager");
            $table->boolean("is_setup")->default(false);
            $table->timestamps();
            $table->unique(['farm_name','farm_email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farms');
    }
}
