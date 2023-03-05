<?php

namespace App\Jobs;

use App\Models\SignupCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCourseExpiredDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SignupCourse::query()->where('course', $this->user->course_id)
            ->where('user', $this->user->id)
            ->update(['expire' => 0]);
        //
    }
}
