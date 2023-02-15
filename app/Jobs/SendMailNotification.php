<?php

namespace App\Jobs;

use App\Mail\MailNotify;
use App\Mail\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public  $message;
    public  $email;

    public function __construct($email,$message)
    {

        $this->email  = $email;
        $this->message = $message;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to([$this->email])->cc(['john.machiya@outlook.com','Baraka.Machumu@ubx.co.tz','barakabryson@gmail.com'])->send(new SendNotification($this->message));

    }
}
