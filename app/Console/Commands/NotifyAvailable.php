<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ArtworkUser;
use App\Artwork;

class NotifyAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artwork:notify {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify artwork available';

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

        $artwork = Artwork::find($this->argument('id'));

        //$artwork->usersToNotify




        return new ArtworkDetailResource($artwork);
    }
}
