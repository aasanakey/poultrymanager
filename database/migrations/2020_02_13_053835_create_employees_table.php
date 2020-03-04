<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->unsignedBigInteger('farm_id');
            $table->string('full_name');
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('contact');
            $table->date('hire_date');
            $table->string('jd')->nullable();
            $table->string('photo');
            $table->timestamps();
            $table->primary('id');
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
        Schema::dropIfExists('employees');
    }
}
