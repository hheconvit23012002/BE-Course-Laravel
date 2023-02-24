<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use Illuminate\Database\Seeder;

class SignupCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->pluck('id')->toArray();
        $courses = Course::query()->pluck('id')->toArray();

        $faker = \Faker\Factory::create();
        $arr = [];
        for($i=1;$i<=1000;$i++){
            $arr[] = [
                'user' => $users[array_rand($users)],
                'course' => $courses[array_rand($courses)],
            ];
        }
        SignupCourse::insert($arr);
        //
    }
}
