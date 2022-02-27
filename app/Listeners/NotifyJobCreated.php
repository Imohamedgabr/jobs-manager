<?php

namespace App\Listeners;

use App\Events\JobCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\JobCreatedNotification;
use Notification;

class NotifyJobCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\JobCreated  $event
     * @return void
     */
    public function handle(JobCreated $event)
    {
        // notify only managers
        $users = User::whereHas("roles", function($q){ $q->where("name", "manager"); })->get();
        $details = [];

        foreach($users as $user) {
           Notification::send($user, new JobCreatedNotification($details));
        }
    }
}
