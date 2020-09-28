<?php

namespace App\Console\Commands;

use App\Artwork;
use Illuminate\Console\Command;

class CheckAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artwork:available {id}';

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


        $artwork = Artwork::find($this->argument('id'));

        if ($artwork) {

            if ($artwork->isAvailable()) {
                $this->output->write('kunstwerk ' . $artwork->name .  ' beschikbaar'  , true);
                return true;

            }
            $this->output->write('kunstwerk ' . $artwork->name .  '  niet beschikbaar', true);

            foreach($artwork->rents()->returned(false)->get() as $rent){
                $this->output->write('ontlening ' . $rent->id . ' tot ' . $rent->expire->date, false);
                $this->output->write( ' door ' . $rent->subscription->user->firstname,true);
            }


            return true;

        }

        $this->output->write('kunstwerk niet gevonden', true);

    }
}
