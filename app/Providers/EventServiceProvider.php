<?php

namespace App\Providers;

use App\Events\UserStored;
use App\Listeners\CreateSubscription;
use App\Listeners\LogUserRegistered;
use App\Listeners\SendUserCreated;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Verified;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        Verified::class => [CreateSubscription::class],

        Registered::class => [
            SendEmailVerificationNotification::class,
            LogUserRegistered::class
        ],

        UserStored::class => [SendUserCreated::class]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
