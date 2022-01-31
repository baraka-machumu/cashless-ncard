<?php

namespace App\Jobs;

use App\Helper\PaymentHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public  $data;
    public  $reference;
    public  $tin;
    public  $payment_id;

    public  $billId;

    public  $cat;
    public  $idadi;

    public function __construct($cat,$idadi)
    {
//        $this->data =  $data;
//        $this->reference  =  $reference;
//        $this->tin   =  $tin;
//        $this->payment_id  = $payment_id;
//        $this->billId =  $billId;

        $this->idadi=  $idadi;
        $this->cat  =  $cat;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
                PaymentHelper::getTicket($this->cat,$this->idadi);

//        PaymentHelper::getTicket($this->data,$this->reference,$this->tin, $this->payment_id,$this->billId);
    }
}
