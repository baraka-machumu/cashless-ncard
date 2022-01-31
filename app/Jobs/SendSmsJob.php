<?php

namespace App\Jobs;

use App\Helper\RandomGenerator;
use App\Helper\SmsHelper;
use App\Http\Controllers\Sms\SmsController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public  $message;
    public  $phoneNo;
    public function __construct($message,$phoneNo)
    {
        $this->message =  $message;
        $this->phoneNo =  $phoneNo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $smsapi  =  Config('api.smsapi');

        Http::post($smsapi,[
                'msisdn' => RandomGenerator::addPrefixExtra($this->phoneNo),
                'text' => $this->message,
                'source'=>'N-CARD',
                'reference'=>'onlinesite'
            ]
        );
    }
}
