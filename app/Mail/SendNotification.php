<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public  $message;

    public function __construct($message)
    {

        $this->message =  $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data  =  $this->message;

        echo "message ".$data;

        return $this->subject('N CARD Notification')->view('mail.notification')->with(['data'=>$data]);

    }
}
