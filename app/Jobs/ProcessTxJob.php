<?php

namespace App\Jobs;

use App\Http\Controllers\Agent\TpesaNcardFund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessTxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {

        //process transactions here....

        $data  =  DB::select('call GetTxForTpesaDataSP');

        if (!empty($data)){

            foreach ($data as $row){

                $tx  =  self::apiFn($row->consumer_wallet_id,$row->reference,$row->amount,$row->id,$row->created_at);


                echo 'code '.$tx['code'].' with message '.$tx['message']."\r\n";

            }
        }

        else{

            Log::info('no data found at this time');
        }


        return 'done';
    }


    public  static function apiFn($account,$reference,$amount,$tx_id,$trxdate){

        $tpesa  =  Config('api.TEST_TPESA_CUSTOMER_TX_API');

        $accountSecretKey  =  'jBYIn7U8bfsNFPe6pPhXVKN3uq9PJfDQZPtU5dl26Y0=';


        $trxdate  = date('Y-m-d\TH:i:s'.'\Z',strtotime($trxdate));

        $checksumRow =  $reference.'+'.$trxdate.'+'.$amount.'+'.(string)$tx_id.'+'.$account.$accountSecretKey;

        $checksum = base64_encode(hash('sha256',$checksumRow,TRUE));


        $body  =  [
            'account'=>$account,
            'cellid'=>'',
            'reference'=>$reference,
            'amount'=>(string)$amount,
            'checksum'=>$checksum,
            'transdate'=>$trxdate,
            'transid'=>(string)$tx_id,

        ];

        Log::channel('t-pesa-topup')->info('request body -'.json_encode($body));

        //$amount = 100;

        try {

            $http  = Http::post($tpesa,$body);

            Log::channel('t-pesa-topup')->info('request body -'.json_encode($http->json()));

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

            return ["code"=>TpesaNcardFund::FAILED,"message"=>$message];

        }

        $result = json_encode($http->json());

        //dd($result);

        $result = json_decode($result);

        if ($result->errorCode==200) {

            $update  =  DB::select('call UpdateConsumerTxSp(?)',array($tx_id));

            return ["code" => TpesaNcardFund::SUCCESS, "message" => $result->message];

        }

        return ["code" => TpesaNcardFund::FAILED, "message" => $result->message];


    }
}
