<?php

namespace App\Console\Commands;

use App\Expire;
use App\Notifications\RentExpired;
use App\Rent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MailRentExpires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:rentexpires {days=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail users that rent expires in three days';

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
     * @return mixed
     */
    public function handle()
    {

        $expire = Expire::select('date')
            ->where('expirable_type', 'Rent')
            ->whereColumn('expirable_id', 'id')
            ->latest()
            ->limit(1)
            ->getQuery();

        $rents = Rent::returned(false)
            ->whereHas('expires', function ($q) {
                $q->orderBy('id', 'desc')
                    ->limit(1)
                    ->whereDate('date', '=', Carbon::now()->addDays($this->argument('days')));
            })->get();

        foreach ($rents as $rent) {

            Log::channel('single')->info('rent expires in ' . $this->argument('days') . ' days' . $rent . 'user: ' . $rent->subscription->user);

            $notication = new RentExpired($rent);

            $rent->subscription->user->sendMailchimp($notication->toArray());

          //  $rent->subscription->user->notify(new RentExpired($rent))




        }
    }
}
