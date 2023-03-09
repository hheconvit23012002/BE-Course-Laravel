<?php

namespace App\Http\Controllers;

use App\Events\CourseExpireEvent;
use App\Jobs\UpdateCourseExpiredDatabase;
use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use App\Notifications\CourseExpireNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index(){
        if (Auth::guard('web')->check() ) {
            // Người dùng đã đăng nhập
            dd(Auth::guard('web'));
        } else {
            dd(0);
            // Người dùng chưa đăng nhập
        }
    }
}
