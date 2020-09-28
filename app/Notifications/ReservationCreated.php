<?php

namespace App\Notifications;

use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ReservationCreated extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
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

        Log::channel('single')->info('reservatiocreatedmailsend  ' . $this->reservation);



        return (new MailMessage)
            ->from('admin@artotheek44.com', 'Artotheek#44')
            ->subject('U heeft een nieuw kunstwerk gereserveerd')
            ->greeting('Hallo ' . $notifiable->firstname)
            ->line('U heeft het kunstwerk ' . $this->reservation->artwork->name . ' gereserveerd')
            ->line('Dit kunswerk blijft voor u gereserveerd tot ' . $this->reservation->expire->date );
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

            'name' => 'reservering-nieuw',



            'properties' => [
                'artwork' => $this->reservation->artwork->name,
                'date' => $this->reservation->expire->date
            ]


        ];
    }
}
