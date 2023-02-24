<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [];
        $faker = \Faker\Factory::create();
        for($i=1;$i<=1000;$i++){
            $arr[] = [
                'name'=>$faker->firstName(),
                'description' =>$faker->word,
                'start_date'=> $faker->date($format = 'Y-m-d', $max = 'now'),
                'end_date'=>$faker->date($format = 'Y-m-d', $min = 'now'),
            ];
        }
        Course::insert($arr);
        //
    }
}
