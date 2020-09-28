<?php

namespace App\Observers;

use App\NotifyArtworkAvailable;
use App\Preference;
use Illuminate\Support\Facades\Log;

class PreferenceObserver
{
    public function created(Preference $preference)
    {
        //add tags
        if ($preference->newsletter) {
            $preference->user->mailchimpAddTag('newsletter');
        }
    }

    public function updated(Preference $preference)
    {
        Log::channel('single')->info('preference updated ' . $preference->user );

        //add or remove tags
        if (!$preference->newsletter) {
            $preference->user->mailchimpRemoveTag('newsletter');

        }

        if ($preference->newsletter){
            $preference->user->mailchimpAddTag('newsletter');
        }

    }
}
