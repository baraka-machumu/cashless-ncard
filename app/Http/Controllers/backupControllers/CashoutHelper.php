<?php


namespace App\Http\Controllers\Tpesa;


use App\Helper\RandomGenerator;
use App\Merchant;
use App\MerchantCashIn;
use App\MerchantCashOutRecord;
use App\NcardCollectionAccount;
use App\TpesaRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashoutHelper
{


    public  static  function  process($tin,$amount,$date){

//        $amount  =  100;

        $ref = RandomGenerator::referenceNumber($tin);

        if (app()->environment()=='production'){

            $tpesaUrl  = Config('api.TPESA_DISBURSEMENT_API');


        }
        else{

            $tpesaUrl  = Config('api.TPESA_TEST_DISBURSEMENT_API');

        }

        $merchant  = Merchant::query()->where(['tin'=>$tin])->first();

        $ncardPolicy  =  DB::table('ncard_comission_policy')->select('percentage')->where(['merchant_tin'=>$tin])->first();

        $commission  =  ($ncardPolicy->percentage*$amount);

        $amount  =  $amount-$commission;

        $account  =  $merchant->account_number;

        $dateSystem  = Carbon::now('Africa/Nairobi');

        $dateReal =  date('Y-m-d H:i:s',strtotime($dateSystem));

        $cashoutRec  =  new MerchantCashOutRecord();

        $cashoutRec->amount  =  $amount;
        $cashoutRec->merchant_tin  =  $tin;
        $cashoutRec->initiator  =  'N-CARD-SYSTEM';
        $cashoutRec->initiated_date  =  $dateReal;
        $cashoutRec->tx_reference  = $ref;
        $cashoutRec->trx_date  =   $date;
        $cashoutRec->n_card_commission  =   $commission;

        $cashoutRec->save();

        $transId  = $cashoutRec->id;

        $timestamp  = date('Y-m-d\TH:i:s'.'\Z');

        $data_checksum  = $ref.'+'.$timestamp.'+'.$amount.'+'.$transId.'+'.$account.$secretKey;

        $checksum  =base64_encode(hash('sha256',$data_checksum,true));

        $bankName  =  $merchant->bank_name;
        $accessKey  =  $merchant->access_key;

        $body =     ['account'=>$account,'reference'=>$ref,'amount'=>$amount,
            'transdate'=>$timestamp,'transid'=>$transId,'checksum'=>$checksum,'bankName'=>$bankName,'accessKey'=>$accessKey];

        $tx  =  new TpesaRequest();
        $tx->merchant_tin =  $tin;
        $tx->request_body  = json_encode($body);
        $tx->amount  =  $amount;
        $tx->reference  =  $ref;
        $tx->trx_date  = $date;
        $tx->account_number =  $account;
        $tx->save();

        try {

//            DB::beginTransaction();

            $merchant  = MerchantCashIn::query()->lockForUpdate()->where(['merchant_tin'=>$tin])->first();

            if ($amount<0){

                Log::warning('No Enough Balance');

                Log::channel('t-pesa-log')->error('No Enough Balance for '.$tin);

                return response()->json(['resultcode'=>'01','message'=>'No enough balance']);
            }

            $merchant->amount   = $merchant->amount-($amount+$commission);
            $merchant->total_cashout  =  $merchant->total_cashout+($amount+$commission);
            $merchant->save();

            $nCollection  =  NcardCollectionAccount::query()->where(['account_number'=>'003003'])->first();

            $nCollection->amount  =  $nCollection->amount+$commission;
            $nCollection->total_collected  =  $nCollection->amount+$commission;

            $nCollection->save();

            //todo list make api call before commit.

            Log::channel('t-pesa-log')->error('Request body  '.json_encode($body));

            $result  = Http::post($tpesaUrl,
                ['account'=>$account,'reference'=>$ref,'amount'=>$amount,
                    'transdate'=>$timestamp,'transid'=>$transId,'checksum'=>$checksum,'bankName'=>$bankName,'accessKey'=>$accessKey]);

            $responseBody = (json_decode($result->body()));

            Log::channel('t-pesa-log')->info('RESPONSE = '.json_encode($responseBody));

            $result = (json_decode($result->body()));

            $txResp  = TpesaRequest::where(['reference'=>$ref])->first();

            $txResp->resultcode = $result->resultcode;
            $txResp->message = $result->message;
            $txResp->result = json_encode($result->result);
            $txResp->status= $result->errorCode;
            $txResp->rspid  = $result->result->rspid;
            $txResp->save();

            if ($result->errorCode!=200){

            //   DB::rollBack();

                $rec  = MerchantCashOutRecord::query()->where(['tx_reference'=>$ref])->first();

                $rec->status_id  = 2;// failed.... needs manualy push....

                DB::select('call UpdateForFailedMerchantDailyCollectionSP(?,?)',array($tin,$date));

//                Log::warning($responseBody);

                Log::channel('t-pesa-log')->error(json_encode($responseBody));

                return response()->json(['resultcode'=>'01','message'=>' '.$result->message]);

            }

            DB::select('call UpdateMerchantDailyCollectionSP(?,?)',array($tin,$date));

            DB::table('merchant_cash_out_records')->where(['tx_reference'=>$ref])->update(['status_id'=>1]);

//            DB::commit();

            Log::channel('t-pesa-log')->error(json_encode($responseBody));

            return response()->json(['resultcode'=>'0','message'=>''.$result->message]);

        }

        catch (\Exception $exception){

//            DB::rollBack();

            Log::channel('t-pesa-log')->error('Processing error'.$exception->getMessage());
            Log::channel('t-pesa-log')->error('Processing error Line code'.$exception->getLine());
            Log::channel('t-pesa-log')->error('Processing error'.$exception->getTraceAsString());

            return response()->json(['resultcode'=>'01','message'=>'Processing error, please try again '.$exception->getMessage()]);

        }

    }

}
