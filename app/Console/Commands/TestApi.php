<?php

namespace App\Console\Commands;

use App\Card;
use App\Helper\PaymentHelper;
use App\Jobs\SendSmsJob;
use App\VendorVirtualCard;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to test sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $cards =    DB::select('call GetVendorCardSP');

        echo 'Total data  '.count($cards)."\r\n";


        try {

            foreach ($cards as $index=>$row){

                echo 'Index No '.($index+1)."\r\n";

                $vnumber  = VendorVirtualCard::query()->select('id','card_number')->where(['status'=>0])->first();

                $cc  =  Card::query()->where(['virtual_vendor_card_number'=>$row->card_number])->first();

                if (!$cc){
                    $card  =  Card::query()->where(['card_uid'=>$row->card_uid])->first();
                    $card->card_number =  $vnumber->card_number;
                    $card->virtual_vendor_card_number =  $row->card_number;
                    $success =   $card->save();

                    $vnumber->status  =  1;
                    $vnumber->save();

                    echo 'Success for  '.$row->card_number .' - '.$success."\r\n";

                } else{

                    echo 'Already for  '.$row->card_number ."\r\n";

                }



            }
        }catch (\Throwable $exception){

            Log::info($exception);
            Log::info($exception->getMessage());

            echo 'Exception '.$exception->getMessage()."\r\n";

        }

    }
}
