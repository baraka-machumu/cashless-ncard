<?php

namespace App\Http\Controllers\Transaction;

use App\ConsumerWallet;
use App\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MerchantTransactionController extends Controller
{

    public function  index(){


        $payments  =  $this->paymentsTransactions();

//        return  response()->json($payments);
        $failedDeposits   =  $this->failedDeposits();
        $reversedDeposits =  $this->reversedDeposits();
        $failedPayments =  $this->failedPayments();
        $reversedPayments =  $this->reversedPayments();

        $deposits  =  $this->depositTransactions();

        return view('transactions.merchants.tab',compact('reversedPayments','failedPayments','failedDeposits','reversedDeposits','deposits','payments'));

    }

    public  function  depositTransactions(){

        $deposits  =  DB::table('agent_deposits')
            ->where('agent_deposits.status','=','1')
            ->select('agent_deposits.amount','agent_deposits.agent_wallet_id','agent_deposits.reference',
                'agent_deposits.created_at', 'agent_deposits.status','agents.first_name','agents.last_name')
            ->join('agents','agents.agent_code','agent_deposits.agent_wallet_id')

            ->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }

    public  function  failedDeposits(){

        $failed  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.status','=','0')
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->get();

        return $failed;

    }


    public  function  failedPayments(){

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.status','=','0')
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->get();

        return $payments;


    }

    public  function  reversedPayments(){

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.status','=','3')
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->get();

        return $payments;


//        return view('transactions.consumers.deposits',compact('deposits'));

    }

    public  function  reversedDeposits(){

        $deposits  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.status','=','3')
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }


    public  function  paymentsTransactions(){

        $payments  =  DB::table('consumer_payments')
            ->where(['consumer_payments.status'=>1,'consumer_payments.recipient_type'=>3])

            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference as reference',
                'consumer_payments.created_at', 'consumer_payments.recipient_id','merchants.name as mname','consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->join('merchants','merchants.tin','=','consumer_payments.recipient_id')
            ->get();

        return $payments;


    }

    public  function  paymentsHistory($tin){

        $captureWalletIdException  =  Merchant::where('tin',$tin)->first();


        if (!$captureWalletIdException){

            $message  ='No resource Found ';
            return view('errors.resouce_not_found_exception',compact('message'));
        }

        $payments  =  DB::table('consumer_payments')
            ->where(['consumer_payments.recipient_type'=>3,'consumer_payments.recipient_id'=>$tin])
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference as reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->get();

        $fullName  =  Merchant::where('tin',$tin)->first();

        $fullName =   $fullName->name;

        $totalPayments  =  DB::table('consumer_payments')
            ->where(['consumer_payments.recipient_type'=>3,'consumer_payments.recipient_id'=>$tin])
            ->sum('amount');

        return view('transactions.merchants.payments_history',compact('fullName','payments','totalPayments'));

    }


    public  function  depositsHistory($consumer_wallet_id){

        $deposits  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.consumer_wallet_id',$consumer_wallet_id)
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.ncard_reference as reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')
            ->get();
        $fullName  =  DB::table('consumer_wallets')
            ->where('consumer_wallets.wallet_id',$consumer_wallet_id)
            ->select('consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_wallets.consumers_id')
            ->first();

        $totalDeposits  =  DB::table('consumer_deposits')
            ->where('consumer_wallet_id',$consumer_wallet_id)
            ->sum('amount');

        return view('transactions.consumers.deposits_history',compact('fullName','deposits','totalDeposits'));

    }

}
