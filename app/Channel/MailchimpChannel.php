<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 05/04/2020
 * Time: 11:39
 */

namespace App\Channel;

use DrewM\MailChimp\MailChimp;
use Illuminate\Notifications\Notification;
use Spatie\Valuestore\Valuestore;


class MailchimpChannel
{
    protected $mailchimp;
    protected $list;

    public function __construct()
    {
        $v = Valuestore::make("config.json");
        $this->mailchimp = new MailChimp($v->get('api'));
        $this->list = $v->get('list');

    }

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toArray($notifiable);

        // Send notification to the $notifiable instance...

        $hash = MailChimp::subscriberHash($notifiable->email);



        $this->mailchimp->post("lists/".$this->list."/members/".$hash."/events", $notification->toArray($notifiable));



    }

}
