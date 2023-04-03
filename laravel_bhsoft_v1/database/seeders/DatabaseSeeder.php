<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1000)->create();
        Course::factory(1000)->create();
        SignupCourse::factory(1000)->create();
    }
}
