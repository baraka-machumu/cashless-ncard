<?php

namespace App\Http\Controllers\Wallet;

use App\ConsumerWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class WalletController extends Controller
{


    public  function  merchantWallet(){


        $merchants= DB::table('merchant_collection_accounts')
            ->select('merchant_collection_accounts.amount','merchant_collection_accounts.consumer_wallet_id','merchants.name','merchant_collection_accounts.reference','merchant_collection_accounts.status')
            ->join('merchants', 'merchants.tin', '=', 'merchant_collection_accounts.merchants_id')->get();

        return view('wallets.merchant',compact('merchants'));

    }

    public  function  agentWallet(){

        if (!Gate::allows('manage-wallet')) {

            return view('errors.login_access');

        }
        $agents= DB::table('agent_wallets')
            ->select('agent_wallets.amount','agent_wallets.agents_code','agents.first_name','agents.last_name')
            ->join('agents', 'agents.agent_code', '=', 'agent_wallets.agents_code')->get();
        return view('wallets.agent',compact('agents'));

    }

    public  function  consumerWallet(){

        if (!Gate::allows('manage-wallet')) {

            return view('errors.login_access');

        }
        $consumers= DB::table('consumer_wallets')
            ->select('consumer_wallets.created_at','consumer_wallets.amount','consumer_wallets.wallet_id','consumers.first_name','consumers.last_name')
            ->join('consumers', 'consumers.id', '=', 'consumer_wallets.consumers_id')->get();

        return view('wallets.consumer',compact('consumers'));
    }

    public function getConsumerWalletDetails($wallet_id){

        $wallet = DB::table('consumer_wallets')
            ->where('wallet_id', $wallet_id)
            ->select('consumer_wallets.amount','consumer_wallets.created_at','status.name as status_name','consumer_wallets.wallet_id','consumers.first_name','consumers.last_name', 'consumers.status_id')
            ->join('consumers', 'consumers.id', '=', 'consumer_wallets.consumers_id')
            ->join('status','status.id','consumer_wallets.consumers_status_id')
            ->first();
        $sumPayment = DB::table('consumer_payments')->where('consumer_wallet_id', $wallet_id)->sum('amount');
        $sumDeposits = DB::table('consumer_deposits')->where('consumer_wallet_id', $wallet_id)->sum('amount');


        if(empty($wallet)){
            return response()->json(['error'=>true, 'data'=>[]]);
        }

        return response()->json(['error'=>false, 'data'=>$wallet, 'payments'=>$sumPayment, 'deposits'=>$sumDeposits]);
    }


    public  function  ncardWalletInfo(){

        $info = null;

        $wallet =  DB::table('consumer_wallets');

        $consumerBalance =  number_format($wallet->sum('amount'), 2, '.', ',');

        $active_card  =  $wallet->where(['consumers_status_id'=>1])->count();
        $inactive_card  =  $wallet->where(['consumers_status_id'=>0])->count();

        return view('wallets.info',compact('consumerBalance','active_card','inactive_card'));

    }
}
