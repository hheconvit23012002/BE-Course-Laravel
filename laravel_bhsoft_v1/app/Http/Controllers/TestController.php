<?php

namespace App\Http\Controllers;

use App\Events\CourseExpireEvent;
use App\Jobs\UpdateCourseExpiredDatabase;
use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use App\Notifications\CourseExpireNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index(){
        $ldate = date('Y-m-d');
        $courses = User::query()
            ->addSelect('courses.id as course_id','courses.name as course_name')
            ->addSelect('users.id','users.name','users.email as email')
            ->Join('signup_courses','signup_courses.user','users.id')
            ->Join('courses','signup_courses.course','courses.id')
            ->where('courses.end_date','<',$ldate)
            ->where('signup_courses.expire',1)
            ->first();
        CourseExpireEvent::dispatch($courses);
        UpdateCourseExpiredDatabase::dispatch($courses);
    }
}
