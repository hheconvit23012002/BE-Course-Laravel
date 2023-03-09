<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function apiDashboard()
    {
        try {
            $courses = Course::query()->selectRaw('count(id) as total')
                ->get();
            $users = User::query()->selectRaw('count(id) as total')
                ->get();
            $courses_signup = Course::query()
                ->whereExists(function ($query) {
                    $query->select(Course::raw(1))
                        ->from('signup_courses')
                        ->whereRaw('courses.id = signup_courses.course');
                })
                ->count();
            $top_five_user_signuped = User::query()
                ->addSelect('users.id', 'users.name')
                ->selectRaw('COUNT(signup_courses.course) as number_courses')
                ->leftJoin('signup_courses', 'signup_courses.user', 'users.id')
                ->groupBy('users.id')
                ->orderBy('number_courses', 'desc')
                ->havingRaw(
                    'number_courses >= (
                    select DISTINCT COUNT(signup_courses.course) as d
                    from signup_courses
                    group by user order by d desc LIMIT 1 offset 4
                )'
                )
                ->where('users.role', 1)
                ->get();
            $rank = 1;
            $prev_score = null;
            foreach ($top_five_user_signuped as $user) {
                if ($prev_score !== null && $user->number_courses !== $prev_score) {
                    $rank++;
                }
                $user->rank = $rank;
                $prev_score = $user->number_courses;
            }
            $data['courses'] = $courses;
            $data['users'] = $users;
            $data['courses_signup'] = $courses_signup;
            $data['top_user'] = $top_five_user_signuped;
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }
}
