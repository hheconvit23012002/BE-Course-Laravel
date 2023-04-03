<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignupCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::query()->inRandomOrder()->first();
        $course = Course::query()->inRandomOrder()->first();

        return [
            'user' => $user->id,
            'course' => $course->id,
            'unique_key' => $user->id . '_' . $course->id,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (SignupCourse $signupCourse) {
            $signupCourse->unique_key = $signupCourse->user . '_' . $signupCourse->course;
            $signupCourse->save();
        });
    }
}
