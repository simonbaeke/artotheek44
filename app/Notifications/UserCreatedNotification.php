<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserCreatedNotification extends Notification
{
    use Queueable;

    protected $pw;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pw)
    {
        $this->pw = $pw;
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

        $firstname = 'admin';
        if (Auth::check()) {
            $firstname = strtolower(Auth::user()->firstname);
        }

        Log::channel('single')->info('password email gezonden naar  ' . $notifiable);

        return (new MailMessage)
            ->from($firstname . '@artotheek44.com','Artotheek#44')
            ->subject('U bent geregistreerd op artotheek#44')
            ->greeting('Hallo ' . $notifiable->firstname)
            ->line('U bent geregistreerd op artotheek#44')
            ->line('U kan inloggen met volgende gegevens:')
            ->line('emailadres: ' . $notifiable->email)
            ->line('paswoord: ' . $this->pw);
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
