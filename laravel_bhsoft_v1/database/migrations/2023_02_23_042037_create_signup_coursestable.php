<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signup_courses', function (Blueprint $table) {
            $table->unsignedBigInteger('user');
            $table->unsignedBigInteger('course');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course')->references('id')->on('courses')->onDelete('cascade');
            $table->primary(['user','course']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signup_course');
    }
}
