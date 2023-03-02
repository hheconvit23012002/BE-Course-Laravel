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
    public function index(){
        return view('admin.dashboard.index');
    }
    public function apiDashboard(){
        $courses = Course::query()->selectRaw('count(id) as total')
            ->get();
        $users = User::query()->selectRaw('count(id) as total')
            ->get();
        $courses_signup = SignupCourse::query()
            ->selectRaw('count(user) as total')
            ->groupBy('course')
            ->having('total','>',0)
            ->count('*');
        $topFiveUserSignuped = User::query()
            ->addSelect('users.id','users.name')
            ->selectRaw('COUNT(signup_courses.course) as number_courses')
            ->leftJoin('signup_courses','signup_courses.user','users.id')
            ->groupBy('users.id')
            ->orderBy('number_courses','desc')
            ->where('users.role',1)
            ->limit(5)
            ->get();
        $data['courses'] = $courses;
        $data['users'] = $users;
        $data['courses_signup'] = $courses_signup;
        $data['top_user'] = $topFiveUserSignuped;
        return $this->successResponse($data);
    }
}
