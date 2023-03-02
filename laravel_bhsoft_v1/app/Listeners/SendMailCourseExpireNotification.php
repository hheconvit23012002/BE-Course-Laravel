<?php

namespace App\Listeners;

use App\Events\CourseExpireEvent;
use App\Notifications\CourseExpireNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendMailCourseExpireNotification implements ShouldQueue
{
    public function handle(CourseExpireEvent $event)
    {
        Notification::send($event->user, new CourseExpireNotificationMail($event->user));
    }
}
