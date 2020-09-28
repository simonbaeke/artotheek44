<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class ActivateEmailNotification extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        Log::channel('single')->info('email verification mail send to: ' . $this->user->email);

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $this->user->id]);
        return (new MailMessage)
            ->from('info@artotheek44.com','artoheek#44')

            ->greeting('Hallo ' . $this->user->firstname)
            ->subject('Bevestig uw email adres')
            ->line('Gelieve op de onderstaande knop te drukken om uw email adres te bevestigen. Deze link is 1 uur geldig')
            ->action(
                'Bevestig uw email adres',
                $url
            )
            ->line('Indien u deze account niet aangemaakt heeft, hoeft u verder niks te doen');
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
