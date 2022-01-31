<?php

namespace App\Console\Commands;

use App\ConsumerReverseTrx;
use App\ConsumerWallet;
use App\Helper\PaymentHelper;
use App\Http\Controllers\Retry\PushFailedDataController;
use App\Monitor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RetryFailedTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dd {date} {id}';

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
        $input = $this->argument('date');

        $consumer_wallet_id  =  $this->argument('id');

        $res  = DB::select('call ReverseTopUpSP(?,?)',array($input,$consumer_wallet_id));

        echo 'passed db query check '."\r\n";

        foreach ($res as $index=>$row){

            echo 'loop inside '.$index."\r\n";

            DB::beginTransaction();

            $tx  =  new ConsumerReverseTrx();

            $tx->consumer_wallet_id =  $row->consumer_wallet_id;
            $tx->consumers_id =  $row->consumers_id;
            $tx->amount =  $row->amount;
            $tx->status =  0;
            $tx->gateway_type =  $row->gateway_type;
            $tx->source_ref =  $row->source_ref;
            $tx->gateway_id =  $row->gateway_id;
            $tx->transaction_date =  $row->transaction_date;
            $tx->mdn =  $row->mdn;
            $tx->current_balance =  $row->current_balance;
            $tx->ncard_reference =  $row->ncard_reference;
            $tx->terminal_device =  $row->terminal_device;
//            $tx->card =  $row->card;
            $tx->save();

            if ($tx){

                DB::table('consumer_deposits')
                    ->where(['consumer_wallet_id'=>$row->consumer_wallet_id,
                        'source_ref'=>$row->source_ref,'mdn'=>$row->mdn])->update(['status'=>4]);

                $walletId  =  ConsumerWallet::lockForUpdate()->where(['wallet_id'=>$row->consumer_wallet_id])->first();

                $walletId->amount  = $walletId->amount-$row->amount;
                $walletId->save();


                DB::commit();

                echo 'successful saved '.$index.'  -  '.$row->consumer_wallet_id."\r\n";

//                dd('done');

            }

            else {

                DB::rollBack();

                echo 'Rollback '.$index.'  -  '.$row->consumer_wallet_id."\r\n";

            }

        }


        dd('done');

    }
}
