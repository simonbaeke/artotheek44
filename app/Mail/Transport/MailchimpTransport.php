<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 05/04/2020
 * Time: 09:49
 */

namespace App\Mail\Transport;

use App\Emails;
use DrewM\MailChimp\MailChimp;
use Illuminate\Mail\Transport\Transport;
use Spatie\Valuestore\Valuestore;
use Swift_Mime_Message;
use Swift_Mime_SimpleMessage;


class MailchimpTransport extends Transport
{

    protected $list;
    protected $mailchimp;

    public function __construct()
    {
        $v = Valuestore::make('config.json');

        $this->list = $v->get('list');
        $this->mailchimp = new MailChimp($v->get('list'));

    }

    /**
     * Send the given Message.
     *
     * Recipient/sender data will be retrieved from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
     * This is the responsibility of the send method to start the transport if needed.
     *
     * @param Swift_Mime_SimpleMessage $message
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Array $message, &$failedRecipients = null)
    {
        // TODO: Implement send() method.
    }
}
