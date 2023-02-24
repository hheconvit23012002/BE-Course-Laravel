<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $arr = [];
        for($i=1;$i<=1000;$i++){
            $arr[] = [
                'name' => $faker->firstName().' '. $faker->lastName(),
                'email' => $faker->email,
                'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'phone_number'=> $faker->phoneNumber,
                'logo' => $faker->imageUrl(),
                'password' => $faker->text,
            ];
        }
        User::insert($arr);
    }
}
