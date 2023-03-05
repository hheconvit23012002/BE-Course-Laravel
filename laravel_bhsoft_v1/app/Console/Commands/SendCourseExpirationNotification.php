<?php

namespace App\Console\Commands;

use App\Events\CourseExpireEvent;
use App\Events\UserRegisterEvent;
use App\Jobs\UpdateCourseExpiredDatabase;
use App\Models\Course;
use App\Models\User;
use App\Notifications\CourseExpireNotificationMail;
use App\Notifications\UserRegisterNotificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class SendCourseExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-course-expiration-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ldate = date('Y-m-d');
        $courses = User::query()
            ->addSelect('courses.id as course_id', 'courses.name as course_name')
            ->addSelect('users.id', 'users.name', 'users.email as email')
            ->Join('signup_courses', 'signup_courses.user', 'users.id')
            ->Join('courses', 'signup_courses.course', 'courses.id')
            ->where('courses.end_date', '<', $ldate)
            ->where('signup_courses.expire', '1')
            ->get();
        foreach ($courses as $course) {
            CourseExpireEvent::dispatch($course);
            UpdateCourseExpiredDatabase::dispatch($course);
        }
    }
}
