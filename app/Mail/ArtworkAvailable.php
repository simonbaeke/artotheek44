<?php

namespace App\Mail;

use App\Artwork;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArtworkAvailable extends Mailable
{
    use Queueable, SerializesModels;

    public $artwork;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Artwork $artwork)
    {
        $this->artwork = $artwork;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@artotheek44.com')
            ->subject('Kunstwerk beschikbaar')
            ->view('mails.artworkavailable');
    }
}
