<?php

namespace App\Http\Controllers\Support;

use App\Agent;
use App\Helper\CardHelper;
use App\Helper\RandomGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CustomerSupportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function  index(){
        if (!Gate::allows('customer-care')) {
            return view('errors.login_access');
        }
        $result  = false;
        $resultP  =  false;
        return view('support.index',compact('result','resultP'));
    }
    public  function  getResult(Request $request){
        if (!Gate::allows('customer-care')) {
            return view('errors.login_access');
        }
        try {


            $result  = true;
            $phone_number  =  $request->phoneNo;
            $wallet_number  =  $request->walletNo;
            $cardNo =  $request->cardNo;


            if (!empty($phone_number)){
                $pref = array('T','C');
                if(!is_numeric($cardNo)){
                    $cardNo  =  CardHelper::getCardNumberUsingVendorNumber($cardNo);
                    if (!$cardNo){
                        Session::flash('alert-warning','No data found v');
                        return back()->withInput();
                    }
                }

                $walletCard  =   DB::table('consumer_cards as cc')
                    ->select('c.phone_number','cc.card_number','wallet_id')
                    ->join('consumer_wallets as cw','cw.wallet_id','=','cc.consumers_wallet_id')
                    ->join('consumers as c','c.id','cw.consumers_id')
                    ->where(['cc.card_number'=>$cardNo])
                    ->first();

                if (!$walletCard){
                    Session::flash('alert-warning','No data found by phone number');
                    return  redirect('support/customer-query')->withInput();
                }

                $phone_number =  $walletCard->phone_number;
                $wallet_number  =  $walletCard->wallet_id;
            }
            else if (substr($request->walletNo,0,2)=='NC'){
                $walletCard  =   DB::table('consumer_cards as cc')
                    ->select('c.phone_number','cc.card_number','wallet_id')
                    ->join('consumer_wallets as cw','cw.wallet_id','=','cc.consumers_wallet_id')
                    ->join('consumers as c','c.id','cw.consumers_id')
                    ->where(['cw.wallet_id'=>$request->walletNo])
                    ->first();
                if (!$walletCard){
                    Session::flash('alert-warning','No data found  by wallet');
                    return  redirect('support/customer-query')->withInput();
                }
                $phone_number =  $walletCard->phone_number;
                $wallet_number  =  $walletCard->wallet_id;

            }
            else {
                $walletCard  =   DB::table('consumer_cards as cc')
                    ->select('c.phone_number','cc.card_number','wallet_id')
                    ->join('consumer_wallets as cw','cw.wallet_id','=','cc.consumers_wallet_id')
                    ->join('consumers as c','c.id','cw.consumers_id')
                    ->where(['cc.card_number'=>$cardNo])
                    ->first();

                if (!$walletCard){
                    Session::flash('alert-warning','No data found by card');
                    return  redirect('support/customer-query')->withInput();
                }

                $phone_number =  $walletCard->phone_number;
                $wallet_number  =  $walletCard->wallet_id;
            }

            $consumerDeposits  =[];

            $consumerPayments  = [];

            $walletDetails  =   DB::table('consumer_wallets as cw')
                ->select('cw.created_at','cc.card_number','s.name as status_name','cw.wallet_id','cw.amount as balance','sc.name as wallet_status',
                    'c.email','c.first_name','last_name','c.agent_code','g.name as sex','c.phone_number','cc.status_id as cardStatusId','cw.consumers_status_id')
                ->join('consumers as c','c.id','=','cw.consumers_id')

                ->leftJoin('consumer_cards as cc','cc.consumers_wallet_id','=','cw.wallet_id')
                ->leftJoin('status as s','s.id','=','cc.status_id')
                ->leftJoin('status as sc','sc.id','=','cw.consumers_status_id')
                ->leftJoin('genders as g','g.id','=','c.gender_id');

            if (!empty($cardNo)){
                $walletDetails =   $walletDetails->where(['cc.card_number'=>$cardNo]);
            }

//            else if (!empty($phone_number)){
//                $walletDetails =   $walletDetails->where(['c.phone_number'=>(int)$phone_number,'c.status_id'=>1]);
//            }
            else {
                $walletDetails=    $walletDetails->where(['cw.wallet_id'=>$wallet_number]);
            }
            $walletDetails= $walletDetails->first();
            $agentName  =  null;
            if (!empty($walletDetails->agent_code)){
                $Name  =  Agent::query()->select('first_name','last_name')->where(['agent_code'=>$walletDetails->agent_code])->first();
                if ($Name){
                    $agentName =  $Name->first_name.'  '.$Name->last_name;
                } else{
                    $agentName = null;
                }
            }
            $events  =  base_url();
            $resultP  =  false;
        }catch (\Throwable $exception){
            Log::error($exception);
            Session::flash('alert-danger','Something went wrong');
            return  redirect('support/customer-query')->withInput();
        }

        $desc  = 'Search customer details';
        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$cardNo??$wallet_number,'CUSTOMER','SEARCH'));

        return view('support.index',compact('resultP','agentName','result','walletDetails','consumerDeposits','consumerPayments'));

    }

}
