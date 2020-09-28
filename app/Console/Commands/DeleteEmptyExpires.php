<?php

namespace App\Console\Commands;

use App\Expire;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteEmptyExpires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:deleteempty';

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
        $expires = Expire::with('expirable')->get();

        foreach ($expires as $expire) {
            if ($expire->expirable == null){


                Log::channel('single')->info('null' . $expire);
                $expire->delete();

            }
        }
    }
}
