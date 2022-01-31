<?php


namespace App\Http\Controllers\Agent;


use App\NcardDisbursementAccount;
use App\NcardDisburseToAgent;
use App\TpesaRequestTopup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TpesaNcardFund
{

    public  const  NOT_ENOUGH_BALANCE = 'NOT_ENOUGH_BALANCE';
    public  const  SUCCESS = 'SUCCESS';

    public  static  function  saveRecord($amount,$reference,$account,$trxdate,$transid){

        $ncard  = NcardDisbursementAccount::query()->lockForUpdate()->where(['wallet_number'=>'008008'])->first();
        $ncard->total_balance  =  $ncard->total_balance-$amount;
        $ncard->save();

        $tpesa  =  Config('api.TPESA_AGENT_TOP_UP_API');

        $accountSecretKey  =  'jBYIn7U8bfsNFPe6pPhXVKN3uq9PJfDQZPtU5dl26Y0=';

        $checksum =  $reference.$trxdate.$amount.$transid.$accountSecretKey;

        $body  =  [
            'account'=>$account,
            'reference'=>$reference,
            'amount'=>$amount,
            'transdate'=>$trxdate,
            'transid'=>$transid,
            'checksum'=>$checksum
        ];

//        dd($body);
//        $http  = Http::post($tpesa,[
//           'account'=>$account,
//            'reference'=>$reference,
//            'amount'=>$amount,
//            'transdate'=>$trxdate,
//            'transid'=>$transid,
//            'checksum'=>$checksum
//        ]);


//        dd($http->json());

        $fund  =  NcardDisburseToAgent::query()->where(['wallet_number'=>'008008'])->lockForUpdate()->first();

        $fund->money_to_agent =  $fund->money_to_agent+$amount;
        $fund->save();

        $request  = new  TpesaRequestTopup();
        $request->request  =  json_encode($body);
        $request->created_by  =  Auth::user()->id;
        $request->amount  =  $amount;
        $request->deposit_id  = $transid;
        $request->reference  = $reference;
        $request->save();

        return ["code"=>"SUCCESS","message"=>"success"];

    }

}
