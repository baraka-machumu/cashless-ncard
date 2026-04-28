<?php


namespace App\Http\Controllers\Tpesa;


use App\Helper\RandomGenerator;
use App\Merchant;
use App\MerchantCashOutRecord;
use App\NcardCollectionAccount;
use App\TpesaRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashoutHelper
{


    public  static  function  process($tin,$amount,$date){
        $tpesaPrevRequest  =  DB::table('tpesa_request')
            ->select('id','reference')->where(['merchant_tin'=>$tin,'trx_date'=>$date])->first();



        $tpesaUrl  = Config::get('api.TPESA_DISBURSEMENT_API').'/api/temesa-gepg/bill-processing';

        $merchant  = Merchant::query()->where(['tin'=>$tin])->first();

        $ncardPolicy  =  DB::table('ncard_comission_policy')->select('percentage')->where(['merchant_tin'=>$tin])->first();

        $commission  =  ($ncardPolicy->percentage*$amount);

        $amount  =  $amount-$commission;

        $account  =  $merchant->account_number;

        $dateSystem  = Carbon::now('Africa/Nairobi');

        $dateReal =  date('Y-m-d H:i:s',strtotime($dateSystem));


        $body = [
            'bill_description' => "bill for " . $dateReal,
            'amount'           => $amount,
            'currency'         => 'TZS',
            'customer_code'    => 'NIDC'
        ];
        if ($tpesaPrevRequest){
            $ref = $tpesaPrevRequest->reference;
            $body['reference_no'] = $ref; // update ref in body

        }else{

            $ref = RandomGenerator::referenceNumber($tin);
            $cashoutRec  =  new MerchantCashOutRecord();
            $body['reference_no'] = $ref; // update ref

            $cashoutRec->amount  =  $amount;
            $cashoutRec->merchant_tin  =  $tin;
            $cashoutRec->initiator  =  'N-CARD-SYSTEM';
            $cashoutRec->initiated_date  =  $dateReal;
            $cashoutRec->tx_reference  = $ref;
            $cashoutRec->trx_date  =   $date;
            $cashoutRec->n_card_commission  =   $commission;
            $cashoutRec->save();


            $tx  =  new TpesaRequest();
            $tx->merchant_tin =  $tin;
            $tx->request_body  = json_encode($body);
            $tx->amount  =  $amount;
            $tx->reference  =  $ref;
            $tx->trx_date  = $date;
            $tx->account_number =  $account;
            $tx->save();
        }

        try {

            $nCollection  =  NcardCollectionAccount::query()->where(['account_number'=>'003003'])->first();
            $nCollection->amount  =  $nCollection->amount+$commission;
            $nCollection->total_collected  =  $nCollection->amount+$commission;
            $nCollection->save();

            //todo list make api call before commit.

            Log::channel('t-pesa-log')->error('Request body  '.json_encode($body));

            $result  = Http::post($tpesaUrl,$body);

            $result = (json_decode($result));

            Log::channel('t-pesa-log')->info('TPESA-RESPONSE',['MESSAGE'=>$result]);

            $txResp  = TpesaRequest::where(['reference'=>$ref])->first();

            $txResp->resultcode = $result->error;
            $txResp->message = $result->message;
            $txResp->result = json_encode($result);
            $txResp->status= $result->statusCode;
            $txResp->rspid  = $result->bill_id??null;
            $txResp->save();

            if ($result->error){
                $rec  = MerchantCashOutRecord::query()->where(['tx_reference'=>$ref])->first();
                $rec->status_id  = 2;// failed.... needs manualy push....
                DB::select('call UpdateForFailedMerchantDailyCollectionSP(?,?)',array($tin,$date));
                return response()->json(['resultcode'=>'01','message'=>' '.$result->message]);

            }else{

                DB::select('call UpdateMerchantDailyCollectionSP(?,?)',array($tin,$date));
                DB::table('merchant_cash_out_records')->where(['tx_reference'=>$ref])->update(['status_id'=>1]);
                return response()->json(['resultcode'=>'0','message'=>''.$result->message]);
            }

        }

        catch (\Throwable $exception){
            Log::channel('t-pesa-log')->error('Processing error'.$exception->getTraceAsString());
            return response()->json(['resultcode'=>'01','message'=>'Processing error, please try again '.$exception->getMessage()]);
        }

    }

}
