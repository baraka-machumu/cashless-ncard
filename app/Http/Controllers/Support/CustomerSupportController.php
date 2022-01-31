<?php

namespace App\Http\Controllers\Support;

use App\Agent;
use App\Helper\RandomGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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

        $result  = true;
        $phone_number  =  $request->phoneNo;
        $wallet_number  =  $request->walletNo;
        $cardNo =  $request->cardNo;

        if (empty($phone_number) and empty($wallet_number) and  empty($cardNo)){

            Session::flash('alert-warning','please fill at least one field');

            return back()->withInput();

        }

        if (empty($phone_number) and empty($wallet_number)){

            $walletCard  =   DB::table('consumer_cards as cc')
                ->select('c.phone_number','cc.card_number','wallet_id')
                ->join('consumer_wallets as cw','cw.wallet_id','=','cc.consumers_wallet_id')
                ->join('consumers as c','c.id','cw.consumers_id')
                ->where(['cc.card_number'=>$cardNo])
                ->first();

            if (!$walletCard){

                Session::flash('alert-warning','No data found');

                return back()->withInput();
            }

            $phone_number =  $walletCard->phone_number;

            $wallet_number  =  $walletCard->wallet_id;


        }

        else if (substr($request->walletNo,0,2)=='NC'){
            $walletCard  =   DB::table('consumer_cards as cc')
                ->select('c.phone_number','cc.card_number','wallet_id')
                ->join('consumer_wallets as cw','cw.wallet_id','=','cc.consumers_wallet_id')
                ->join('consumers as c','c.id','cw.consumers_id')
                ->where(['cw.wallet_id'=>$request->walletNo,'c.status_id'=>1])
                ->first();

            if (!$walletCard){

                Session::flash('alert-warning','No data found');

                return back()->withInput();
            }

            $phone_number =  $walletCard->phone_number;

            $wallet_number  =  $walletCard->wallet_id;

        }

        else {
            $walletCard  =   DB::table('consumer_cards as cc')
                ->select('c.phone_number','cc.card_number','wallet_id')
                ->join('consumer_wallets as cw','cw.wallet_id','=','cc.consumers_wallet_id')
                ->join('consumers as c','c.id','cw.consumers_id')
                ->where(['c.phone_number'=>(int)$phone_number,'c.status_id'=>1])
                ->first();

            if (!$walletCard){

                Session::flash('alert-warning','No data found');

                return back()->withInput();
            }

            $phone_number =  $walletCard->phone_number;

            $wallet_number  =  $walletCard->wallet_id;

        }

        $consumerDeposits  =  DB::table('consumer_deposits as cd')
            ->select('cd.ncard_reference','cd.amount','cd.created_at','cd.mdn','current_balance','previous_balance');


        if (!empty($phone_number)){

            $consumerDeposits = $consumerDeposits->where(['mdn'=>RandomGenerator::addPrefixExtra($phone_number)]);

        }

        else {
            $consumerDeposits = $consumerDeposits->where(['consumer_wallet_id'=>$wallet_number]);
        }

        $consumerDeposits= $consumerDeposits->limit(10)->latest('cd.created_at')->get();

        $consumerPayments  =  DB::table('consumer_payments as cp')
            ->select('cp.consumer_wallet_id','cp.reference','cp.amount','cp.created_at','cp.current_balance','cp.previous_balance','c.phone_number')
            ->join('consumers as c','c.id','=','cp.consumers_id');

//        if (!empty($phone_number)){
//
//            $consumerPayments = $consumerPayments->where(['cp.consumer_wallet_id'=>$wallet_number]);
//
//        }
//
//        else {

            $consumerPayments = $consumerPayments->where(['cp.consumer_wallet_id'=>$wallet_number]);
//        }
        $consumerPayments=      $consumerPayments->latest()->limit(40)->get();

        $walletDetails  =   DB::table('consumer_wallets as cw')
            ->select('cw.created_at','cc.card_number','s.name as status_name','cw.wallet_id','cw.amount as balance','sc.name as wallet_status',
                'c.email','c.first_name','last_name','c.agent_code','g.name as sex','c.phone_number','cc.status_id as cardStatusId','cw.consumers_status_id')
            ->join('consumers as c','c.id','=','cw.consumers_id')

            ->leftJoin('consumer_cards as cc','cc.consumers_wallet_id','=','cw.wallet_id')
            ->leftJoin('status as s','s.id','=','cc.status_id')
            ->join('status as sc','sc.id','=','cw.consumers_status_id')
            ->join('genders as g','g.id','=','c.gender_id');


        if (!empty($cardNo)){

            $walletDetails =   $walletDetails->where(['cc.card_number'=>$cardNo]);

        }

        else if (!empty($phone_number)){

            $walletDetails =   $walletDetails->where(['c.phone_number'=>(int)$phone_number,'c.status_id'=>1]);


        }
        else {
//

            $walletDetails=    $walletDetails->where(['cw.wallet_id'=>$wallet_number]);


        }

        $walletDetails= $walletDetails->first();

//        return response()->json($walletDetails);


        $agentName  =  null;
        if (!empty($walletDetails->agent_code)){

            $Name  =  Agent::query()->select('first_name','last_name')->where(['agent_code'=>$walletDetails->agent_code])->first();

            $agentName =  $Name->first_name.'  '.$Name->last_name;

        }
//        return response()->json($walletDetails);

        $events  =  base_url();

        $resultP  =  false;

        return view('support.index',compact('resultP','agentName','result','walletDetails','consumerDeposits','consumerPayments'));

    }

}
