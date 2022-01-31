<?php

namespace App\Http\Controllers\TopUp;

use App\Agent;
use App\AgentWallet;
use App\ConsumerCard;
use App\ConsumerDeposit;
use App\ConsumerWallet;
use App\FeeCollectionAccount;
use App\FeeDisbursmentAccount;
use App\Helper\ApiHelper;
use App\Helper\DataEncryption;
use App\Helper\RandomGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TopUpController extends Controller
{
    public function agentTopUpUser($agent_code, Request $request){
//        TODO make all these queries under transaction
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'pin'=>'required'
        ]);

        if ($validator->fails()){
            return response()->json(['error'=>true, 'message' => $validator->errors()->all()]);
        }
        try{
        $walletId = $request->get('wallet_id');
        $card_no = $request->get('card_number');
        $amount = $request->get('amount');
        $imei = $request->get('imei');
        $phone = $request->get('phone');

        $agent  = Agent::query()->where(['agent_code'=>$agent_code])->first();

        $sender  =  $agent->first_name.' '.$agent->middle_name.' '.$agent->last_name;

        $pin  =  $request->get('pin');

        if (empty($walletId) && empty($card_no)){
            return response()->json(['error' => true, 'message' => 'Either wallet number or card number is needed']);
        }

        $a_wallet = AgentWallet::where('agents_code', $agent_code)->first();

        if (!$a_wallet){
            return response()->json(['error' => true, 'message' => 'Agent does not exist']);
        }

           $pin  =   $request->get('pin');


        if (!Hash::check($request->get('pin'), $a_wallet->pin)) {

            return response()->json(['error' =>true, 'message' => 'Incorrect pin']);
        }

        if ($a_wallet->agents_status_id != 1){
            return response()->json(['error' => true, 'message' => 'Agent is not available for service']);
        }


        if ($a_wallet->amount < $amount){
            return response()->json(['error' => true, 'message' => 'No enough balance']);
        }

        if ($amount<1000){
            return response()->json(['error' => true, 'message' => 'Can not top up amount less than 1000']);
        }

        $reference  = RandomGenerator::referenceNumber($walletId);

//        top up consumer wallet
        $c_wallet = null;

        DB::beginTransaction();


            if (!empty($walletId)){
                $c_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();
                if (!$c_wallet){
                    return response()->json(['error' => true, 'message' => 'Wallet does not exist']);
                }
                DB::table('consumer_wallets')->where('wallet_id', $walletId)->update(['amount' => $c_wallet->amount+$amount]);
            }

            else{
                $c_card = ConsumerCard::where('card_number', $card_no)->first();

                if (!$c_card){
                    return response()->json(['error' => true, 'message' => 'Card does not exist']);
                }

                $walletId = $c_card->consumers_wallet_id;

                $c_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();
                DB::table('consumer_wallets')->where('wallet_id', $walletId)->update(['amount' => $c_wallet->amount+$amount]);
            }

//        reduce from agent wallet

            DB::table('agent_wallets')->where('agents_code', $agent_code)->update(['amount' => $a_wallet->amount-$amount]);

            $c_deposit = new ConsumerDeposit();
            $c_deposit->consumer_wallet_id = $walletId;
            $c_deposit->amount = $amount;
            $c_deposit->status = 1;
            $c_deposit->consumers_id = $c_wallet->consumers_id;
            $c_deposit->ncard_reference = $reference;
            $c_deposit->gateway_type = 2;    //2 means topup by agent
            $c_deposit->gateway_id = $agent_code;
            $c_deposit->save();

// record it in collection account
            $collect = new FeeDisbursmentAccount();
            $collect->fee_charges = 0;
            $collect->agent_code = $agent_code;
            $collect->consumer_deposits_reference = $reference;
            $collect->save();

            DB::table('references')->where(['reference'=>$reference])->update(['status'=>1]);

            $timestamp  =  Carbon::now('Africa/Nairobi');


            DB::commit();

          //  ApiHelper::agentopup($reference,$imei,$reference,$amount,$phone,$sender, $timestamp);

            return response()->json(['error' => false, 'wallet' => $a_wallet]);
        } catch (\Exception $exception){

            DB::rollBack();
            Log::info('Server Error : '.json_encode($exception->getMessage()));

            return response()->json(['error' => true, 'message' =>'Sever Error, can top up']);

        }
    }

    public  function  testAgent(Request $request){

        $timestamp  =  Carbon::now('Africa/Nairobi')->toISOString();


      return  ApiHelper::agentopup($request->utilityref,$request->imei,$request->reference,$request->amount,$request->phone,$request->sender, $timestamp);

    }
}
