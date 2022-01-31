<?php

namespace App\Jobs;

use App\Mail\MailNotify;
use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public  $imei_no;
    public  $password;
    public  $email;
    public function __construct($imei_no,$password,$email)
    {

        $this->password =  $password;
        $this->imei_no =  $imei_no;
        $this->email  =  $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to([$this->email])->send(new MailNotify($this->password,$this->imei_no));


    }
}
