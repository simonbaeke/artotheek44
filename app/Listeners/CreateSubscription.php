<?php

namespace App\Listeners;

use App\Actions\Subscription\CreateOldSubscription;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CreateSubscription
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
     * @param  IlluminateAuthEventsVerified $event
     * @return void
     */
    public function handle($event)
    {
        Log::channel('single')->info('Create Subscription listener');

        Log::channel('single')->info('Create Subscription: ' . $event->user->firstname . " " . $event->user->lastname);

        $create = new CreateOldSubscription();
        $create->execute([
            'user_id' => $event->user->id
        ]);

    }
}
