<?php

namespace App\Http\Controllers\Tpesa;

use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\MerchantCollection;
use App\Merchant;
use App\MerchantCashIn;
use App\MerchantCashOutRecord;
use App\Permission;
use App\TpesaRequest;
use Carbon\Carbon;
use Carbon\Doctrine\DateTimeDefaultPrecision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CashOutController extends Controller
{

    public  function  index(Request  $request){

        $merchant  = Merchant::query()->get();

        $result  = false;

        $rev = array();


        $tin = null;

        $commission =  null;

        $mname = null;

        if(isset($_GET['check'])){

            $result = true;

            $tin = $request->tin;

            $mname  =  Merchant::query()->select('name')->where(['tin'=>$tin])->first()->$mname;

                //->name;

            if ($request->action=='2'){

                return  $this->viewManual($tin);

            }
            $ncardPolicy  =  DB::table('ncard_comission_policy')->select('percentage')->where(['merchant_tin'=>$tin])->first();

            $commission  = $ncardPolicy->percentage;

            $rev  =  DB::select('call GetDailyCollectionRevenueByTinNoSP (?)',array($tin));

        }

        return view('cash_out.index',compact('mname','rev','merchant','result','tin','commission'));

    }


    public  function  viewManual($tin){

        $merchant  = Merchant::query()->get();
        $result = true;

        $rev  =  DB::select('call GetCollectionForMerchantUnPaidSP (?)',array($tin));


//        dd($rev);
        $ncardPolicy  =  DB::table('ncard_comission_policy')->select('percentage')->where(['merchant_tin'=>$tin])->first();

        $commission  = $ncardPolicy->percentage;

        $mname  =  Merchant::query()->select('name')->where(['tin'=>$tin])->first()->name;


        return view('cash_out.manual',compact('mname','rev','merchant','result','tin','commission'));

    }


    public  function  view($reference,$tin){

        $tx = DB::select('call ViewMerchantCashoutStatusPerReferenceNoSP(?,?)',array($reference,$tin))[0];

        return  view('cash_out.view',compact('tx','tin','reference'));

    }

    public  function  pay(Request  $request){


//        if (!Gate::allows('reconcile')) {
//
//            return view('errors.login_access');
//
//        }

        $tin  = $request->tin;
        $date = $request->date;

        try {

            $result  = DB::select('call GetCollectionForMerchantByDateSP(?,?)',array($tin,$date));



            if ($result[0]->amount!=null){

                if ($result[0]->amount!=0){

                    /**
                     * SUCCESS BLOCK, FIRE API FOR T-PESA HERE
                     */

                    $amount  = $result[0]->amount;

                    $payment  =  CashoutHelper::process($tin,$amount,$date);

                    Session::flash('alert-success',''.$payment->getData()->message);

                    return  redirect('Fund/transfer-to-merchant');

                }

                Session::flash('alert-danger','Failed Amount is less than 0');
                return back();

            }

            Session::flash('alert-danger','Failed, no amount found in the record..');

            return back();

        }

        catch (\Throwable $exception){

            Log::channel('t-pesa-log')->error('PUSH-ERROR '.$exception->getMessage());
            Log::channel('t-pesa-log')->error('PUSH-ERROR-LINE'.$exception->getLine());
            Log::channel('t-pesa-log')->error('PUSH-ERROR-LINE'.$exception->getTraceAsString());

            Session::flash('alert-danger','Failed, server processing exception '.$exception->getMessage());

            return back();

        }


    }


    public  function  repay(Request  $request){

        if (!Gate::allows('reconcile')) {

            return view('errors.login_access');

        }


        try {

            $ref  =  $request->reference;
            $amount =  $request->amount;
            $tin =  $request->tin;
            $date =  $request->date;

            $tpesaUrl  = Config('api.TPESA_DISBURSEMENT_API');

            $secretKey  = Config('api.TPESA_SECRETE_KEY');

            $txTpesaData  = TpesaRequest::where(['reference'=>$ref,'amount'=>$amount])->first();

            $merchant  = Merchant::query()->where(['tin'=>$tin])->first();

            $timestamp  = date('Y-m-d\TH:i:s');
            $timeToSend  = date('Y-m-d\TH:i:s'.'\Z',strtotime($txTpesaData->created_at));

            $data_checksum  = $ref.'+'.$timeToSend.'+'.$amount.'+'.$txTpesaData->id.'+'.$merchant->account_number.$secretKey;

            $checksum  =base64_encode(hash('sha256',$data_checksum,true));


            $body  =  ['account'=>$merchant->account_number,'reference'=>$ref,'amount'=>$amount,
                'transdate'=>$timeToSend,'transid'=>$txTpesaData->id,'checksum'=>$checksum];


            Log::channel('t-pesa-log')->info('REQUEST = '.json_encode($body));


            $result  = Http::post($tpesaUrl,
                ['account'=>$merchant->account_number,'reference'=>$ref,'amount'=>$amount,
                    'transdate'=>$timeToSend,'transid'=>$txTpesaData->id,'checksum'=>$checksum]);

            $responseBody = (json_decode($result->body()));

            Log::channel('t-pesa-log')->info('RESPONSE = '.json_encode($responseBody));

            $result = (json_decode($result->body()));

            $txResp  = TpesaRequest::where(['reference'=>$ref])->first();

            $txResp->resultcode = $result->resultcode;
            $txResp->message = $result->message;
            $txResp->result = json_encode($result->result);
            $txResp->status= $result->errorCode;
            $txResp->rspid  = $result->result->rspid;
            $txResp->re_initiated_at = $timestamp;
            $txResp->re_initiated_by =  Auth::user()->id;
            $txResp->save();

            if ($result->errorCode!=200){

//                DB::rollBack();

                $rec  = MerchantCashOutRecord::query()->where(['tx_reference'=>$ref])->first();

                $rec->status_id  = 2;// failed.... needs manualy push....

                DB::select('call UpdateForFailedMerchantDailyCollectionSP(?,?)',array($tin,$date));

//                Log::warning($responseBody);

                Log::channel('t-pesa-log')->error(json_encode($responseBody));
                Session::flash('alert-danger',$result->message);

                return back();

              //  return response()->json(['resultcode'=>'01','message'=>' '.$result->message]);

            }

            DB::select('call UpdateMerchantDailyCollectionSP(?,?)',array($tin,$date));

            DB::table('merchant_cash_out_records')->where(['tx_reference'=>$ref])->update(['status_id'=>1]);

//            DB::commit();

            Log::channel('t-pesa-log')->error(json_encode($responseBody));

            Session::flash('alert-danger',$result->message);
            return back();


        }
        catch(\GuzzleHttp\Exception\GuzzleException $e) {

            Session::flash('alert-danger','Network Error Time-out');
            return back();

        }
        catch (\Throwable $exception){

            Log::error($exception->getMessage());
            Log::error($exception);

            Log::channel('t-pesa-log')->error('PUSH-ERROR '.$exception->getMessage());
            Log::channel('t-pesa-log')->error('PUSH-ERROR-LINE'.$exception->getLine());
            Log::channel('t-pesa-log')->error('PUSH-ERROR-LINE'.$exception->getTraceAsString());

            Session::flash('alert-danger','Failed, server processing exception '.$exception->getMessage());

            return back();

        }


    }
}
