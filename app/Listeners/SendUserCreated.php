<?php

namespace App\Listeners;

use App\Notifications\AdminCreatedNotification;
use App\Notifications\UserCreatedNotification;
use Illuminate\Support\Facades\Log;

class SendUserCreated
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
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        Log::channel('single')->info('User created by admin: ' . $event->user->firstname . " " . $event->user->lastname . " passwoord = " . $event->password ." notify: " . $event->notify);

        $user = $event->user;
        if ($event->notify) {
            if ($user->hasRole('admin')) {
                $event->user->notify(new AdminCreatedNotification($event->password));
            } else {
                $event->user->notify(new UserCreatedNotification($event->password));

            }
        }
    }
}
