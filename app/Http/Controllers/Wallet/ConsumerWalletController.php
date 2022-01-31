<?php

namespace App\Http\Controllers\Wallet;

use App\Consumer;
use App\ConsumerWallet;
use App\ConsumerCard;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\topup_trnx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Throwable;

class ConsumerWalletController extends Controller
{



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

}
