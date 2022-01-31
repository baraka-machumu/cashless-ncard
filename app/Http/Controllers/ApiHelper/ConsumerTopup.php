<?php

namespace App\Http\Controllers\ApiHelper;

use App\ConsumerDeposit;
use App\ConsumerWallet;
use App\FeeDisbursmentAccount;
use App\Helper\RandomGenerator;
use App\Jobs\SendSmsJob;
use App\TxDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsumerTopup
{

    /**
     * Api for debiting consumer wallet.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public static  function storeDeposit($data){


        Log::channel('tx-deposit')->error('Payload from mno : '.json_encode($data));


        $secret_key  =  'jBYIn7U8bfsNFPe6pPhXVKN3uq9PJfDQZPtU5dl26Y0=';

        $data_checksum  =   ($data->transdate.$data->gateway_name.$data->amount.$data->wallet_id.$secret_key);

        $checksum  =base64_encode(hash('sha256',$data_checksum,true));

        if ($checksum!=$data->checksum){

            return response()->json(['resultcode' => '1','message' => 'bad request']);

        }


        $walletId =   $data->wallet_id;

        $reference  =  $data->reference;
        $amount =  $data->amount;
        $mdn  =  $data->mdn;

        $gateway_type   =  $data->gateway_name;


        if ($gateway_type=='T-PESA'){

            $gateway_type = 3;
        }

        else if ($gateway_type=='M-PESA'){

            $gateway_type =  1;

        }

        else if ($gateway_type=='TIGO-PESA'){

            $gateway_type =  2;

//            return response()->json(['resultcode' => '1','message' => 'Failed To Debit Consumer']);

        }

        else if ($gateway_type=='AIRTEL-MONEY'){

            $gateway_type =  4;
        }
        else if ($gateway_type=='HALOPESA'){

            $gateway_type =  5;
        }
        $c_wallet = DB::table('consumer_wallets as w')
            ->where(['wallet_id'=>strtoupper($walletId)])
            ->select('w.wallet_id','c.phone_number','w.amount','consumers_id')
            ->join('consumers as c','c.id','=','w.consumers_id')
            ->first();

        if (!$c_wallet){

            return response()->json(['resultcode' => '1','message' => 'Failed To Credit Consumer  wallet does not exist']);

        }

        DB::beginTransaction();
        try {

            $c_deposit = new ConsumerDeposit();


            $previousBalance  =  $c_wallet->amount;
            $newBalance  =  $previousBalance+$amount;

            $c_deposit->consumer_wallet_id =strtoupper($walletId);
            $c_deposit->amount = $amount;
            $c_deposit->status = 1;
            $c_deposit->consumers_id = $c_wallet->consumers_id;
            $c_deposit->source_ref = $reference;
            $c_deposit->gateway_type = 1;    //1 means top up by mno
            $c_deposit->gateway_id = $gateway_type;  //todo list weka id ya ukweli
            $c_deposit->transaction_date = $data->transdate;
            $c_deposit->mdn  = $mdn;
            $c_deposit->ncard_reference  = RandomGenerator::referenceNumber($walletId);
            $c_wallet->previous_balance  =  $previousBalance;
            $c_wallet->current_balance  =  $newBalance;
            $c_deposit->save();

            DB::table('consumer_wallets')->where(['wallet_id'=>$walletId])->update(['amount' =>$newBalance]);

            // record it in collection account

            $collect = new FeeDisbursmentAccount();
            $collect->fee_charges = 0; //todo list hii fee charges should be dynamic form db
            $collect->agent_code = 3;  //todo list weka id ya ukweli
            $collect->consumer_deposits_reference = $data->reference;
            $collect->save();

            DB::commit();

            Log::channel('tx-deposit')->info('Successful top up consumer : '.$walletId);

            $sms  =  $data->reference.' Imethibitishwa Umepokea TZS '.$amount.' kutoka '.$mdn.' kwenye N CARD number '.strtoupper($walletId);

            SendSmsJob::dispatch($sms,$c_wallet->phone_number);

            return response()->json(['resultcode' => '0', 'sms'=>$sms,'message' => 'Confirmed '.$data->reference.' You have Successful Debited your N card  with walletId '.$walletId]);

        } catch (\Exception $exception){

            Log::channel('tx-deposit')->error('Can\'t top up consumer : '.$exception);
            DB::rollBack();

            return response()->json(['resultcode' => '1','message' => 'Failed to top up consumer '.$exception->getMessage()]);


        }

    }



}
