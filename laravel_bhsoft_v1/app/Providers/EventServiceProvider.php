<?php

namespace App\Providers;

use App\Events\CourseExpireEvent;
use App\Events\UserRegisterEvent;
use App\Listeners\SendMailCourseExpireNotification;
use App\Listeners\SendMailNotification;
use App\Listeners\UpdateDateBaseCourseExpireNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegisterEvent::class => [
            SendMailNotification::class,
        ],
        CourseExpireEvent::class => [
            SendMailCourseExpireNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
