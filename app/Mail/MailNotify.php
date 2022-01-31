<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $password;
    public  $imei_no;
    public function __construct($password,$imei_no)
    {

        $this->password =  $password;

        $this->imei_no  =  $imei_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $password  =  $this->password;
        $imei_no  =  $this->imei_no;

        return $this->subject('Access Notification')->view('mail.send_password',compact('password','imei_no'));

    }
}
