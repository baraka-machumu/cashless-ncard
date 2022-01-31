<?php

namespace App\Http\Controllers;

use App\BillQuantity;
use App\Consumer;
use App\ConsumerCard;
use App\ConsumerPayment;
use App\ConsumerWallet;
use App\FeeCollectionAccount;
use App\Jobs\ProcessTicketJob;
use App\MerchantCollectionAccount;
use App\ServiceProduct;
use App\TempoTx;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TestApiController extends Controller
{

    public function cardPayment(Request $request){
        $validator = Validator::make($request->all(), [
            'tin' => 'required',
            'card_uid' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(["error"=>true,"message"=>$validator->errors()->all()]);
        }

//        $amount = $request->get('amount');
        $tin = $request->get('tin');

        $service_id  =  $request->service_id;

        $fee_charges = 0;
//        $amount += $fee_charges;

        $c_card = ConsumerCard::where('card_uid', $request->get('card_uid'))->first();
        if ($c_card->status_id != 1){
            return response()->json(['error' => true, 'message' => 'Card not active']);
        }

        $walletId = $c_card->consumers_wallet_id;
        $consumer_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();


        if ($consumer_wallet->consumers_status_id != 1) {
            return response()->json(['error' => true, 'message' => 'Consumer is not active']);
        }

//        consumers id
        $consumer_id = $consumer_wallet->consumers_id;

        $reference_bulk =  $request->get('reference');

        $data  =  json_decode($request->get('products'));

//        $tempoTx  =  TempoTx::where(['sha_reference'=>$reference_bulk])->first();
//
//        if(!$tempoTx){
//
//            return response()->json(['error' => true, 'message' => 'Bad payment request']);
//
//        } else {
//
//            if ($tempoTx->sha_reference!=$reference_bulk){
//
//                return response()->json(['error' => true, 'message' => 'Bad payment format request']);
//
//            }
//        }

        DB::beginTransaction();
        try {

            $reference = $reference_bulk;

//        reduce from consumer wallet

            $c_payment = new ConsumerPayment();
            $c_payment->consumer_wallet_id = $walletId;
            $c_payment->fee_charges = $fee_charges;
            $c_payment->status = 1;
            $c_payment->consumers_id = $consumer_id;
            $c_payment->reference = $reference;
            $c_payment->recipient_type = 3;
            $c_payment->recipient_id = $tin;
            $c_payment->service_id =  $service_id;
            $c_payment->save();


            $c_payment_id  =  $c_payment->id;

//        record it in collection account
            $collect = new FeeCollectionAccount();
            $collect->fee_charges = $fee_charges;
            $collect->type = 2;
            $collect->consumer_payments_reference = $reference;
            $collect->save();

            $total_price  =  0;
            for($i=0; $i<sizeof($data); $i++){

                $billQuantity  = new BillQuantity();

                if ($data[$i]->id==1){
                    $prices  =  ServiceProduct::query()->select('price')->where(['service_id'=>$service_id,'category'=>'A'])->first();


                    $total_price =  $total_price+$data[$i]->quantity*$prices->price;

                }

                else if($data[$i]->id==2){
                    $prices  =  ServiceProduct::query()->select('price')->where(['service_id'=>$service_id,'category'=>'C'])->first();


                    $total_price =  $total_price+$data[$i]->quantity*$prices->price;

                }

                else{
                    return response()->json(['error' => true, 'message' => 'Invalid category']);

                }

                $billQuantity->payment_id  = $c_payment_id;
                $billQuantity->product_id  =  $data[$i]->id;
                $billQuantity->quantity  =  $data[$i]->quantity;
                $billQuantity->total_price  =  $total_price;
                $billQuantity->save();

            }

            if ($total_price>20000){

                if (empty($request->get('pin'))){

                    return response()->json(['error' => true, 'message' => 'Pin is required']);

                }
                if (!Hash::check($request->get('pin'), $consumer_wallet->pin)) {
                    return response()->json(['error' => true, 'message' => 'Incorrect pin']);
                }
            }

            if ($consumer_wallet->amount < $total_price) {
                return response()->json(['error' => true, 'message' => 'No enough balance']);
            }

            //        top up merchant account
            $account = new MerchantCollectionAccount();
            $account->amount = $total_price;
            $account->consumer_wallet_id = $walletId;
            $account->reference = $reference;
            $account->merchants_id = $tin;
            $account->status = 1;
            $account->save();

            DB::table('consumer_wallets')->where('consumers_id', $consumer_id)->update(['amount' => $consumer_wallet->amount - $total_price]);

            DB::commit();

//        TODO send user notifications

            $consumer = Consumer::where('id', $consumer_id)->first();

            //call job to handle ucc ticketing
            ProcessTicketJob::dispatch($data,$reference,$tin, $c_payment_id)->delay(now('Africa/Nairobi')->addRealSeconds(1));

            $affectedRows = TempoTx::where(['sha_reference'=>$reference_bulk])->delete();

            return response()->json([
                'error' => false,
                'ref' => $reference,
                'consumer' => $consumer->first_name.' '.$consumer->last_name

            ]);


        } catch (\Exception $ex){
            DB::rollBack();

            Log::channel('tx-payment')->error('General for payment   time '.Carbon::now('Africa/Nairobi') .'  Exception stack'.$ex);
            return response()->json(['error' => true, 'message' => 'Could not complete operation ']);
        }
    }



    public  function  mobileVersion(){

        return response()->json(['error'=>false,'version'=>'1.0']);
    }

    public  function  posVersion(){

        return response()->json(['error'=>false,'version'=>'1.0']);
    }


}
