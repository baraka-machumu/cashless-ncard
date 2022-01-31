<?php


namespace App\Http\Controllers\Tpesa;


use App\Http\Controllers\Agent\TpesaNcardFund;
use App\Http\Controllers\Controller;
use App\NcardDisbursementAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class TpesaController extends Controller
{

    public  function balance(){

        $account  =  NcardDisbursementAccount::query()->get();

        return view('tpesa.index',compact('account'));

    }


    public  function  checkBalance($account){

        Log::info('account '.$account);

        $result  = self::processBalanceCheck($account);

        $resultcode  =  '0';

        $result =  ($result['data']);

        if ($result->errorCode!=200){

            $resultcode  =  '01';

        }
        return response()->json(['message'=>$result->message,'resultcode'=>$resultcode,'balance'=>$result->result->balance]);

    }

    public  static  function  processBalanceCheck($account){

        /** @var  $tpesaUrl */

        $url  = Config('api.TEST_TPESA_NCARD_DISBURSEMENT_BALANCE_API');

        try {

            $http  = Http::post($url,[
                'msisdn'=>$account,

            ]);

            $resultJson = json_encode($http->json());

            $result = json_decode($resultJson);

            Log::info($resultJson);

            return ["code"=>TpesaNcardFund::SUCCESS,'data'=>$result];

        }

        catch (\Throwable $exception){

            Log::channel('t-pesa-topup')->error($exception->getMessage());
            Log::channel('t-pesa-topup')->error($exception->getTraceAsString());
            Log::channel('t-pesa-topup')->error($exception->getLine());
            Log::channel('t-pesa-topup')->error($exception);

            $message  = 'SERVER COMMUNICATION GENERAL ERROR 500';

            if ($exception->getCode()==0){

                $message  =  'T-PESA CONNECTION PROBLEM';
            }

            return ["code"=>TpesaNcardFund::FAILED,"message"=>$exception->getMessage()];

        }


    }
}
