<?php

namespace App\Notifications;

use App\Artwork;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use App\Channel\MailchimpChannel;

class ArtworkAvailableNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $artwork;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Artwork $artwork)
    {
        $this->artwork = $artwork;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MailchimpChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::channel('single')->info('artworkavailablenotification: ' . $this->artwork);

        return (new MailMessage)
                    ->line($this->artwork->name . 'is beschikbaar')
                    ->action('Reserveerknop', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        //notifiable == user
        return [
            'name' => 'artwork-available',
            'properties' => [
                'artwork' => $this->artwork->name
            ]
        ];
    }
}
