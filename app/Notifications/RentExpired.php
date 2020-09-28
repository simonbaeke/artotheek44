<?php

namespace App\Notifications;

use App\Channel\MailchimpChannel;
use App\Rent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RentExpired extends Notification
{
    use Queueable;

    protected $rent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Rent $rent)
    {
        $this->rent = $rent;
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
        return (new MailMessage)
                    ->line('Uw ontlening verloopt bijna.')
                    ->line($this->rent->artwork->name)
                    ->line('Thank you for using our application!');
    }

    public function toMailchimp($notifiable){
        return [

            'name' => 'ontlening-verlopen',

            'properties' => [
                'artwork' => $this->rent->artwork->name,
                'date' => $this->rent->expire->date
            ]


        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable = null)
    {
        return [

            'name' => 'ontlening-verloopt',

            'properties' => [
                'artwork' => $this->rent->artwork->name,
                'date' => $this->rent->expire->date
            ]


        ];
    }
}
