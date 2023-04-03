<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->firstName().' '. $faker->lastName(),
            'email' => $faker->unique()->email,
            'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'phone_number'=> $faker->phoneNumber,
            'logo' => $faker->imageUrl(),
            'password' => $faker->text,
        ];
    }
}
