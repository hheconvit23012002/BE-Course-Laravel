<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Notifications\UserRegisterNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendMailNotification implements ShouldQueue
{
    public function handle(UserRegisterEvent $event)
    {
        Notification::send($event->user, new UserRegisterNotificationMail($event->user));
    }
}
