<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tpesa\CashoutHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PushTemesaPayment extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push-temesa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command  to push temesa payments';

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
     * @return int
     */
    public function handle()
    {

        $tin  = '40040040';

        $date  = date('Y-m-d',strtotime("-1 days"));

        try {

            $result  = DB::select('call GetCollectionForMerchantByDateSP(?,?)',array($tin,$date));

            if ($result[0]->amount!=null){

                if ($result[0]->amount!=0){

                    /**
                     * SUCCESS BLOCK, FIRE API FOR T-PESA HERE
                     */

                    $amount  = $result[0]->amount;

                    $payment  =  CashoutHelper::process($tin,$amount,$date);

                    Log::channel('t-pesa-log')->error('PUSH-ERROR '.$payment->getData()->message);

                    dd($payment->getData()->message);

                    return  true;

                }

                Log::channel('t-pesa-log')->error('PUSH-ERROR AMOUNT IS ZERO FOR  TIN '.$tin);
                return  false;



            }

            Log::channel('t-pesa-log')->error('PUSH-ERROR AMOUNT IS NULL FOR  TIN '.$tin);
            return  false;


        }catch (\Throwable $exception){

            Log::channel('t-pesa-log')->error('PUSH-ERROR '.$exception->getMessage());
            Log::channel('t-pesa-log')->error('PUSH-ERROR-LINE'.$exception->getLine());
            Log::channel('t-pesa-log')->error('PUSH-ERROR-LINE'.$exception->getTraceAsString());

            Session::flash('alert-danger','Failed');

            return  false;

        }


    }
}
