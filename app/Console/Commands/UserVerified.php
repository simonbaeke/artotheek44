<?php

namespace App\Console\Commands;

use App\Events\TestEvent;
use App\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Console\Command;

class UserVerified extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verified {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $user = User::whereEmail($this->argument('user'))->first();

        if ($user == null) {
            $this->output->write('user '. $this->argument('user').' niet gevonden', true);
            return;
        }

        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new Verified($user));
            $this->output->write('user geverifieerd', true);
        } else {
            $this->output->write('user is al geverifieerd', true);
        }


    }
}
