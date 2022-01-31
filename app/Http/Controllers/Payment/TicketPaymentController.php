<?php

namespace App\Http\Controllers\Payment;

use App\BillQuantity;
use App\Consumer;
use App\ConsumerCard;
use App\ConsumerPayment;
use App\ConsumerWallet;
use App\FeeCollectionAccount;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use App\Merchant;
use App\MerchantCashIn;
use App\MerchantCollectionAccount;
use App\ServiceProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TicketPaymentController extends Controller
{


    public  function requestTicket(){

        return response()->json(["resultcode"=>'00',"message"=>'success','data'=>['ref'=>2333,'ticketPrice'=>44]]);

    }

    public  function  payMerchant(Request $request){

        Log::channel('tx-ticket-payload')->info("Ticket  Request payload : ".json_encode($request->all()));

        $validator = Validator::make($request->all(), [

            'tin' => 'required',
            'card_uid' => 'required',
            'category'=>'required',
            'pin'=>'required'
        ]);

        if ($validator->fails()){

            return response()->json(["error"=>true,"message"=>$validator->errors()->all()]);
        }
        try{

        $TICKET_BASE_POINT= base_url().'/lantana/v1/wbs/purchase-ticket';

//        dd($TICKET_BASE_POINT);
        $tin  = $request->tin;
        $card_uid = $request->card_uid;


        $c_card = ConsumerCard::query()->select('status_id','consumers_wallet_id')->where('card_uid', $request->get('card_uid'))->first();

        if (!$c_card){

            return response()->json(["error"=>true, 'message' => 'Card not available']);

        }

        if ($c_card->status_id != 1){
            return response()->json(["error"=>true, 'message' => 'Card not active']);
        }

        $walletId = $c_card->consumers_wallet_id;

        $consumer_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();

        if ($consumer_wallet->consumers_status_id != 1) {
            return response()->json(["error"=>true, 'message' => 'Consumer is not active']);
        }
        $reference = RandomGenerator::referenceNumber($walletId);

//        consumers id
        $consumer_id = $consumer_wallet->consumers_id;
        $consumer = Consumer::query()->select('phone_number')->where('id', $consumer_id)->first();

        $ticketPrice = $request->amount;

        if (!Hash::check($request->get('pin'), $consumer_wallet->pin)) {

            return response()->json(['error' =>true, 'message' => 'Incorrect pin']);
        }

        if ($consumer_wallet->amount < $ticketPrice) {

            return response()->json(['error' =>true, 'message' => 'No enough balance']);
        }


        $TICKET_BASE_POINT= base_url().'/lantana/v1/wbs/purchase-ticket';

        $requestBody  =    ["EventCode"=>$request->event_code,
            "PhoneNumber"=>$consumer->phone_number,
            "CardUID"=>$request->card_uid,
            "Amount"=>$request->amount,
            "PriceCode"=>$request->price_code,
            "ChannelCode"=>"1",
            "walletId"=>$consumer_wallet->wallet_id,
            "CategoryCode"=>$request->category

        ];

        $dataFromApi  =   Http::post($TICKET_BASE_POINT,$requestBody);

        $result  =  $dataFromApi->json();
        Log::channel('tx-ticket-payload')->info("Ticket  Request payload : ".json_encode($result));

//        return $result;
        if ($result['resultcode']=='01'){

            return response()->json(["error"=>true,"message"=>$result['message']]);

        }

//         return $result['TicketRef'];
        $reference_customer = $result['TicketRef'];

        $quantity= $request->quantity;

        DB::beginTransaction();


            $fee_charges  =0;

            $c_payment = new ConsumerPayment();

            $c_payment->consumer_wallet_id = $walletId;
            $c_payment->fee_charges = $fee_charges;
            $c_payment->status = 1;
            $c_payment->consumers_id = $consumer_id;
            $c_payment->reference = $reference;
            $c_payment->recipient_type = 3;
            $c_payment->recipient_id = $tin;
            $c_payment->previous_balance =  $consumer_wallet->amount;
            $c_payment->tx_channel_ref =  $reference_customer;
            $c_payment->amount  =  $ticketPrice;
            $c_payment->transaction_type  = 'TICKET';
            $c_payment->save();

            $c_payment_id  =  $c_payment->id;

//        record it in collection account
            $collect = new FeeCollectionAccount();
            $collect->fee_charges = $fee_charges;
            $collect->type = 2;
            $collect->consumer_payments_reference = $reference;
            $collect->save();

            $billQuantity  = new BillQuantity();

            $billQuantity->payment_id  = $c_payment_id;
//            $billQuantity->product_id  =  $service->id;
            $billQuantity->quantity  =  $quantity;
            $billQuantity->total_price  =  $ticketPrice;
            $billQuantity->save();

            $billId  =  $billQuantity->id;


            //        top up merchant account
            $account = new MerchantCollectionAccount();
            $account->amount = $ticketPrice;
            $account->consumer_wallet_id = $walletId;
            $account->reference = $reference;
            $account->merchants_id = $tin;
            $account->status = 1;
            $account->save();

            $balance  =  $consumer_wallet->amount - $ticketPrice;

            $cashIn  =   MerchantCashIn::where('merchant_tin',$tin)->lockForUpdate()->first();

            $cashIn->amount  =$cashIn->amount+$ticketPrice;
            $cashIn->save();

            DB::table('consumer_wallets')->where('consumers_id', $consumer_id)->lockForUpdate()->update(['amount' => $balance]);
            DB::table('consumer_payments')->where('id',$c_payment_id)->update(['current_balance' => $balance]);

            DB::commit();

            $URL_UPDATE_TICKET  = base_url().'/lantana/v1/wbs/ticket';

            Http::put($URL_UPDATE_TICKET,['TicketRef'=>$reference_customer,'CardUID'=>$card_uid,'Amount'=>$ticketPrice,'PaymentRef'=>$reference]);

            $message  =  $reference.' Imethibitishwa, umefanikiwa kulipa TZS '.$ticketPrice.' kwenda '.$tin.'. Salio la akaunti yako ni TZS '.$balance;

            SendSmsJob::dispatch($message, $consumer->phone_number);

            Log::channel('tx-ticket-payment')->info("Ticket payment success: ".$reference.' with phone number '.$consumer->phone_number);

            return response()->json([
                'error' => false,
                'ref' => $reference_customer,
                'created_at'=>$c_payment->created_at

            ]);

        } catch(\Exception $exception){
            DB::rollBack();

            Log::channel('tx-ticket-payment')->info("Ticket processing error : ".json_encode($exception));

            return response()->json(['error' =>false, 'message' => 'Could not make payment '.$exception->getMessage()]);

        }


    }



    public  function  payMerchantByCardNumber(Request $request){

        Log::channel('tx-ticket-payload')->info("Ticket  Request payload : ".json_encode($request->all()));

        $validator = Validator::make($request->all(), [

            'tin' => 'required',
            'card_number' => 'required',
            'category'=>'required',
            'pin'=>'required'
        ]);


        try{

            if ($request->category!='M01'){
                if ($validator->fails()){

                    return response()->json(["error"=>true,"message"=>$validator->errors()->all()]);
                }
                $TICKET_BASE_POINT= base_url().'/lantana/v1/wbs/purchase-ticket';

//        dd($TICKET_BASE_POINT);
                $tin  = $request->tin;
                $card_number = $request->card_number;


                $c_card = ConsumerCard::query()->select('status_id','consumers_wallet_id','card_number')
                    ->where('card_number', $request->get('card_number'))->first();

                if (!$c_card){

                    return response()->json(["error"=>true, 'message' => 'Card not available']);

                }

                if ($c_card->status_id != 1){
                    return response()->json(["error"=>true, 'message' => 'Card not active']);
                }

                $walletId = $c_card->consumers_wallet_id;

                $consumer_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();

                if ($consumer_wallet->consumers_status_id != 1) {
                    return response()->json(["error"=>true, 'message' => 'Consumer is not active']);
                }


//        consumers id
                $consumer_id = $consumer_wallet->consumers_id;
                $consumer = Consumer::query()->select('phone_number')->where('id', $consumer_id)->first();

                $ticketPrice = $request->amount;

                if (!Hash::check($request->get('pin'), $consumer_wallet->pin)) {

                    return response()->json(['error' =>true, 'message' => 'Incorrect pin']);
                }

                if ($consumer_wallet->amount < $ticketPrice) {

                    return response()->json(['error' =>true, 'message' => 'No enough balance']);

                }

            $reference = RandomGenerator::referenceNumber($walletId);
}


            $TICKET_BASE_POINT= base_url().'/lantana/v1/wbs/purchase-ticket';

            $requestBody  =    ["EventCode"=>$request->event_code,
                "PhoneNumber"=>$consumer->phone_number,
                "CardUID"=>$c_card->card_uid,
                "Amount"=>$request->amount,
                "PriceCode"=>$request->price_code,
                "ChannelCode"=>"1",
                "walletId"=>$consumer_wallet->wallet_id,
                "CategoryCode"=>$request->category

            ];

            $dataFromApi  =   Http::post($TICKET_BASE_POINT,$requestBody);

            $result  =  $dataFromApi->json();
            Log::channel('tx-ticket-payload')->info("Ticket  Request payload : ".json_encode($result));

//        return $result;
            if ($result['resultcode']=='01'){

                return response()->json(["error"=>true,"message"=>$result['message']]);

            }

            if ($request->category=='M01'){

                return response()->json([
                    'error' => false,
                    'ref' => $reference,
                    'created_at'=>Carbon::now('Africa/Nairobi')

                ]);
            }

//         return $result['TicketRef'];
            $reference_customer = $result['TicketRef'];

            $quantity= $request->quantity;

            DB::beginTransaction();


            $fee_charges  =0;

            $c_payment = new ConsumerPayment();

            $c_payment->consumer_wallet_id = $walletId;
            $c_payment->fee_charges = $fee_charges;
            $c_payment->status = 1;
            $c_payment->consumers_id = $consumer_id;
            $c_payment->reference = $reference;
            $c_payment->recipient_type = 3;
            $c_payment->recipient_id = $tin;
            $c_payment->previous_balance =  $consumer_wallet->amount;
            $c_payment->tx_channel_ref =  $reference_customer;
            $c_payment->amount  =  $ticketPrice;
            $c_payment->transaction_type  = 'TICKET';
            $c_payment->save();

            $c_payment_id  =  $c_payment->id;

//        record it in collection account
            $collect = new FeeCollectionAccount();
            $collect->fee_charges = $fee_charges;
            $collect->type = 2;
            $collect->consumer_payments_reference = $reference;
            $collect->save();

            $billQuantity  = new BillQuantity();

            $billQuantity->payment_id  = $c_payment_id;
//            $billQuantity->product_id  =  $service->id;
            $billQuantity->quantity  =  $quantity;
            $billQuantity->total_price  =  $ticketPrice;
            $billQuantity->save();

            $billId  =  $billQuantity->id;


            //        top up merchant account
            $account = new MerchantCollectionAccount();
            $account->amount = $ticketPrice;
            $account->consumer_wallet_id = $walletId;
            $account->reference = $reference;
            $account->merchants_id = $tin;
            $account->status = 1;
            $account->save();

            $balance  =  $consumer_wallet->amount - $ticketPrice;

            $cashIn  =   MerchantCashIn::where('merchant_tin',$tin)->lockForUpdate()->first();

            $cashIn->amount  =$cashIn->amount+$ticketPrice;
            $cashIn->save();

            DB::table('consumer_wallets')->where('consumers_id', $consumer_id)->lockForUpdate()->update(['amount' => $balance]);
            DB::table('consumer_payments')->where('id',$c_payment_id)->update(['current_balance' => $balance]);

            DB::commit();

            $URL_UPDATE_TICKET  = base_url().'/lantana/v1/wbs/ticket';

            Http::put($URL_UPDATE_TICKET,['TicketRef'=>$reference_customer,'CardUID'=>$c_card->card_uid,'Amount'=>$ticketPrice,'PaymentRef'=>$reference]);

            $message  =  $reference.' Imethibitishwa, umefanikiwa kulipa TZS '.$ticketPrice.' kwenda '.$tin.'. Salio la akaunti yako ni TZS '.$balance;

            SendSmsJob::dispatch($message, $consumer->phone_number);

            Log::channel('tx-ticket-payment')->info("Ticket payment success: ".$reference.' with phone number '.$consumer->phone_number);

            return response()->json([
                'error' => false,
                'ref' => $reference_customer,
                'created_at'=>$c_payment->created_at

            ]);

        } catch(\Exception $exception){
            DB::rollBack();

            Log::channel('tx-ticket-payment')->info("Ticket processing error : ".json_encode($exception));

            return response()->json(['error' =>false, 'message' => 'Could not make payment '.$exception->getMessage()]);

        }


    }

}
