<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddExpireColumnToSignupcourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('signup_courses', 'expire')) {
            Schema::table('signup_courses', function (Blueprint $table) {
                $table->boolean('expire')->default(1)->after('course');
            });
        }
    }

    public function down()
    {
        Schema::table('signupcourse', function (Blueprint $table) {
            //
        });
    }
}
