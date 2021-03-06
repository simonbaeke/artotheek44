<?php

namespace App\Mail;

use App\Rent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $rent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Rent $rent)
    {
        $this->rent = $rent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@artotheek44.com')
            ->subject('Nieuwe ontlening')
            ->view('mails.rentcreated');
    }
}
