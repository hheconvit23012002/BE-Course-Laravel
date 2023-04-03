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
        return view("test");
    }
}
