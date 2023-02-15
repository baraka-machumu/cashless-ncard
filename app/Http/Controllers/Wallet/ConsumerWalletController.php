<?php

namespace App\Http\Controllers\Wallet;

use App\Card;
use App\Consumer;
use App\ConsumerWallet;
use App\ConsumerCard;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\topup_trnx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Throwable;

class ConsumerWalletController extends Controller
{


    public  function  saveCustomer(Request  $request){
        DB::beginTransaction();
        try {

            $cardU  =  Card::query()->select('card_number','card_uid')
                ->where(['card_number'=>(int)$request->card])->first();
            if (!$cardU){
                if (!$request->card_uid){

                    Session::flash('alert-danger','Invalid CARD ID');

                    return back();
                }
                $card  =  new Card();

                $card->card_uid  = $request->card_uid;
                $card->card_number = $request->card;

                $card->save();
            }

            $first_name = 'Unknown';
            $last_name  = 'Unknown';
            $consumer = new Consumer();

            $consumer->country_code = 'TZA';
            $consumer->first_name = $first_name;
            $consumer->last_name = $last_name;
            $consumer->gender_id = 1;
            $consumer->status_id = 1;
            $consumer->phone_number = $request->phone;
            $consumer->password = Hash::make($request->phone);
            $consumer->api_token = Str::random(60);
            $status  =  $consumer->save();

            $walletId = RandomGenerator::cardNumber($consumer->id);

            $pin  =  random_int(1011,9986);
            $wallet = new ConsumerWallet();
            $wallet->wallet_id = $walletId;
            $wallet->amount =0;// $request->get('amount',0);
            $wallet->consumers_id = $consumer->id;
            $wallet->consumers_status_id = $consumer->status_id;
            $wallet->pin = Hash::make(1234);

            $wallet->save();

            $c_card = new ConsumerCard();

            $c_card->card_number = $request->card;

            if ($cardU) {
                $c_card->card_uid = $cardU->card_uid;

            } else{
                $c_card->card_uid = $request->card_uid;

            }
            $c_card->status_id = 1;
            $c_card->consumers_wallet_id = $walletId;
            $c_card->agent_code  =  null;
            $c_card->consumer_id  = $consumer->id;
            $c_card->save();

            DB::commit();

            Session::flash('alert-danger','successful');

            return back();

        }catch (Throwable $exception){

            Log::error($exception);
            Session::flash('alert-danger','Server error');
            return back();
        }
    }

    public  function  disableAccount(Request $request){

        $walletId  =  $request->walletId;


        $result  =  DB::select('call DisableAccountSP(?)',array($walletId))[0];

        $flash = 'success';
        if ($result->resultcode=='01'){

            $flash ='warning';


        }
        Session::flash('alert-'.$flash,''.$result->message);

        return redirect()->back();

    }

    public  function  disableCard(Request $request){

        $walletId  =  $request->walletId;

//        dd($walletId);
        $result  =  DB::select('call DisableCardSP(?)',array($walletId))[0];

//        return response()->json($result->message);

        $flash = 'success';
        if ($result->resultcode=='01'){

            $flash ='warning';


        }
        Session::flash('alert-'.$flash,''.$result->message);

        return redirect()->back();

    }


    public  function  getRefundView(){


        $res  = false;

        return view('wallets.top_refund_ncard',compact('res'));
    }


    public  function checkTx(Request  $request){


        $res  = true;


    if(strlen($request->card)==8){

        $balance  =DB::table('consumer_wallets as cw')
        ->select('amount','wallet_id','cw.previous_balance','cw.current_topup','cc.card_uid')
        ->join('consumer_cards as cc','cc.consumers_wallet_id','=','cw.wallet_id')
        ->where(['cc.card_uid'=>$request->card])
        ->first();
    } else {

        $balance  =DB::table('consumer_wallets as cw')
        ->select('amount','wallet_id','cw.previous_balance','cw.current_topup','cc.card_uid')
        ->join('consumer_cards as cc','cc.consumers_wallet_id','=','cw.wallet_id')
        ->where(['cc.card_number'=>$request->card])
        ->first();
    }
        if (!$balance){

            Session::flash('alert-danger', 'Card not found');

            return  back();
        }


        $card_number  =$request->card;


        $tx  = DB::select('call getCustomerDepositsTxByDate(?,?,?)',
            array($request->start_date,$request->end_date,$balance->wallet_id));


        return view('wallets.top_refund_ncard',compact('tx','res','card_number','balance'));


    }

    public  function  saveTopup(Request  $request){

        $res  = true;

        $card_number  =$request->card;
        $wallet_id   = $request->wallet_id;
        $phone   = $request->phone;

        DB::beginTransaction();

        try {
            $wallet = ConsumerWallet::query()->lockForUpdate()->where(['wallet_id' => $wallet_id])->first();

            if ($wallet) {

                $pre = $wallet->amount;

                $balance  =  $pre + $request->amount;

                $wallet->amount = $balance;

                $wallet->previous_balance = $pre;
                $wallet->current_topup = $request->amount;

                $wallet->save();


                $cardn  = ConsumerCard::query(['card_uid'=>$request->card])->first();

                if(strlen($request->card)==8){

                    $card_number =    $cardn->card_number;

                }

                $tx = new topup_trnx();

                $tx->amount = $request->amount;
                $tx->card_number = $card_number;
                $tx->prev = $pre;
                $tx->created_by =  Auth::user()->id;
                $tx->save();

                $message = 'Habari, Ndugu mteja wa N-CARD TANZANIA kiasi cha Tsh '.$request->amount.'   Kimerudishwa kwenye account yako.  salio lako  ni Tsh '.$balance;

                $consumer  = Consumer::query()->where(['id'=>$wallet->consumers_id])->select('phone_number')->first();
                $smsapi  =  Config('api.smsapi');

                Http::post($smsapi,[
                        'msisdn' => RandomGenerator::addPrefixExtra($consumer->phone_number),
                        'text' =>$message,
                        'source'=>'N-CARD',
                        'reference'=>'onlinesite'
                    ]
                );


                DB::commit();


                Session::flash('alert-info', 'successful');

                return redirect('refund/top');
            }
        }catch (Throwable $exception){

            DB::rollBack();
            Session::flash('alert-danger', 'Error try again '.$exception->getMessage());

            return redirect('refund/top');
        }

    }

    public  function  verifyTopupRefund(Request  $request){
        $res  = true;
        $balance  =DB::table('consumer_wallets as cw')
            ->select('amount','wallet_id','cw.previous_balance','cw.current_topup','cc.card_uid')
            ->join('consumer_cards as cc','cc.consumers_wallet_id','=','cw.wallet_id')
            ->where(['cc.card_number'=>$request->card])
            ->first();
        if (!$balance){
            Session::flash('alert-danger', 'Card not found');
            return  back();
        }

        $card_number  =$request->card;
        $tx  = DB::table('topup_trnx')->where(['card_number'=>$card_number])->get();
        $engine  = Http::post(base_url().'/lantana/v1/wbs/attendancy-report',
            ['CardUID'=>$balance->card_uid,'StartDate'=>$request->start_date,'EndDate'=>$request->end_date]);
        $engine  = $engine->json();
        if ($engine['resultcode']=='01'){
            $engine  = array();
            $sum = 0;
        }
        else {
            $engine =  json_decode(json_encode($engine['result']));
            $sum = 0;
            foreach($engine as $key=>$value){
                if(isset($value->Amount))
                    $sum += $value->Amount;
            }
        }

        return view('top',compact('sum','res','card_number','balance','tx','engine'));

    }

}
