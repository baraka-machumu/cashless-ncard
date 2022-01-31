<?php

namespace App\Http\Controllers\Merchant;

use App\BillQuantity;
use App\Consumer;
use App\ConsumerCard;
use App\ConsumerPayment;
use App\ConsumerWallet;
use App\FeeCollectionAccount;
use App\Helper\PetrolStationPrice;
use App\Helper\RandomGenerator;
use App\MerchantCollectionAccount;
use App\ServiceProduct;
use App\TempoTx;
use App\TxSoldTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PetrolStationController extends Controller
{

//    TODO record agent who issued transaction
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

        $c_card = ConsumerCard::query()->select('status_id','consumers_wallet_id')->where('card_uid', $request->get('card_uid'))->first();

        if (!$c_card){
            return response()->json(['error' => true, 'message' => 'Card not available']);

        }
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

        $reference = RandomGenerator::referenceNumber($walletId);

        $refCheck  = substr($reference_bulk,0,4);


        if($refCheck=='NC20'){

            $tempoTx  =  TempoTx::query()->select('sha_reference')->where(['sha_reference'=>trim(substr($reference_bulk,4))])->first();

            Log::channel('tx-payment')->info('Get Reference '.substr($reference_bulk,4).' OBJ: '.$tempoTx);

            if(!$tempoTx){

                return response()->json(['error' => true, 'message' => 'Bad payment request']);

            } else {

                if ($tempoTx->sha_reference!=substr($reference_bulk,4)){

                    return response()->json(['error' => true, 'message' => 'Bad payment format request']);

                }
            }
            $referenceBOQ = $reference;

        }
        else {
            $tempoTx  =  DB::table('tx_payments_reference')->where(['QRSource'=>$reference_bulk])->select('TicketDate','Price','CategoryCode','BatchRef','TicketNo','TicketRef')->first();

            $referenceBOQ = $tempoTx->TicketRef.'-'.$tempoTx->TicketNo.'-'.$tempoTx->BatchRef;

        }

        DB::beginTransaction();
        try {

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

            if($refCheck!='NC20') {

                $qrCheck  =   TxSoldTicket::query()->select('BatchRef')->where(['QRSource'=>$reference_bulk])->first();

                Log::channel('tx-payment-log-point')->info(' UCC Bulk reference '.$reference_bulk);
                if ($qrCheck){

                    return response()->json(['error' => true, 'message' => 'Bad QR source']);

                }

                $txSold = new TxSoldTicket();

                $txSold->merchant = $tin;
                $txSold->BatchRef = $tempoTx->BatchRef;
                $txSold->CategoryCode = $tempoTx->CategoryCode;
                $txSold->TicketDate = $tempoTx->TicketDate;
                $txSold->TicketNo = $tempoTx->TicketNo;
                $txSold->TicketRef = $tempoTx->TicketRef;
                $txSold->Price = $tempoTx->Price;
                $txSold->QRSource = $reference_bulk;
                $txSold->ncard_reference = $reference;
                $txSold->save();

            }

            $total_price  =  0;

            $adult  =  null;
            $child  = null;
            $litreQuantity=null;
            for($i=0; $i<sizeof($data); $i++){

                $billQuantity  = new BillQuantity();

                $prices  =  ServiceProduct::query()->select('price')->where(['service_id'=>$service_id,'id'=>$data[$i]->id])->first();

                $litreQuantity = PetrolStationPrice::price( $data[$i]->price,$tin,$data[$i]->id);

                $total_price =  $total_price+$prices->price;

                $billQuantity->payment_id  = $c_payment_id;
                $billQuantity->product_id  =  $data[$i]->id;
                $billQuantity->quantity  =  $litreQuantity;
                $billQuantity->total_price  = $total_price;
                $billQuantity->save();

                $billId  =  $billQuantity->id;

            }

            if ($total_price>10000){

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

//        TODO send user notifications

            if($refCheck!='NC20'){

                DB::table('tx_payments_reference')->where(['QRSource' => $reference_bulk])->update(['is_taken' =>1,'updated_at'=>Carbon::now('Africa/Nairobi')]);

            }

            DB::commit();

            $boq  =  DB::table('bill_quantities as bq')->select('bq.total_price','bq.product_id','sp.product_name','bq.quantity')
                ->where(['bq.payment_id'=>$c_payment_id])
                ->join('service_products as sp','sp.id','=','bq.product_id')
                ->get();

            $consumer = Consumer::query()->select('first_name','last_name')->where('id', $consumer_id)->first();

            return response()->json([
                'error' => false,
                'ref' => $referenceBOQ,
                'boq'=>$boq,
                'consumer' => $consumer->first_name.' '.$consumer->last_name

            ]);

        } catch (\Exception $ex){
            DB::rollBack();
            Log::channel('tx-payment')->error('Could not complete operation  '.$ex);
            return response()->json(['error' => true, 'message' => 'Could not complete operation ']);
        }
    }


}
