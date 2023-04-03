<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        return [
            'name'=>$faker->firstName(),
            'description' =>$faker->word,
            'start_date'=> $faker->date($format = 'Y-m-d', $max = 'now'),
            'end_date'=>$faker->date($format = 'Y-m-d', $min = 'now'),
        ];
    }
}
