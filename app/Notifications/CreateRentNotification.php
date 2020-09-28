<?php

namespace App\Notifications;

use App\Rent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateRentNotification extends Notification
{
    use Queueable;

    public $rent;

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
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       /* return (new MailMessage)
            ->from('info@artotheek44.com','Artotheek#44')
            ->greeting('Gegroet ' . $this->rent->subscription->user->firstname)
            ->subject('Ontlening van ' . $this->rent->artwork->name)
            ->line('U heeft ' . $this->rent->artwork->name
                . ' ontleent tot ' . (new \Carbon\Carbon($this->rent->expires))->toFormattedDateString())
            ->line('Bedankt om Artotheek#44 te gebruiken!');*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
