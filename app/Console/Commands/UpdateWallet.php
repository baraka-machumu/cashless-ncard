<?php

namespace App\Console\Commands;

use App\ConsumerReverseTrx;
use App\ConsumerWallet;
use App\Helper\PaymentHelper;
use App\Http\Controllers\Retry\PushFailedDataController;
use App\Monitor;
use App\VendorVirtualCard;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vc {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run this command for failed job';

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

        $count = $this->argument('count');
        $id  =  6000000000005000;

      for ($i=0; $i<$count; $i++){
         $vnumber  = VendorVirtualCard::query()->select('id','card_number')
             ->where(['init'=>'T'])
             ->orderBy('id','desc')->first();

         if (!$vnumber){
             $card_number  =  $id;
         }

          else{

              $card_number  =  $vnumber->card_number+1;
          }

          $cardSave  = new VendorVirtualCard();

          $cardSave->card_number  =  $card_number;
          $cardSave->init  =  'T';
          $cardSave->save();

      }




    }
}
