<?php

namespace App\Http\Controllers\Transaction;

use App\Bank;
use App\ConsumerDeposit;
use App\ConsumerPayment;
use App\ConsumerWallet;
use App\Http\Controllers\access\ErrorController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConsumerTransactionController extends Controller
{


    public function  index(){

        $deposits  = $this->depositTransactions();
        $payments  =  $this->paymentsTransactions();

//        return response()->json($payments);
        $failedDeposits   =  $this->failedDeposits();
        $reversedDeposits =  $this->reversedDeposits();
        $failedPayments =  $this->failedPayments();
        $reversedPayments =  $this->reversedPayments();

        return view('transactions.consumers.tab',compact('reversedPayments','failedPayments','failedDeposits','reversedDeposits','deposits','payments'));

    }

    public  function  depositTransactions(){

        $deposits = ConsumerDeposit::with('consumerDeposits')->with('consumer_deposit')
            ->with('agent')->where('status', '=',1)->latest('created_at')->paginate('60');


        return $deposits;

    }

    public  function  failedDeposits(){

        $failed  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.status','=','0')
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.ncard_reference as reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->get();

//        $failed = ConsumerDeposit::with('consumerDeposits')->with('agentDeposits')->where('status', 1)->get();


        return $failed;

    }

    public  function  failedPayments(){

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.status','=','0')
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference as reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->get();

        return $payments;


    }

    public  function  reversedPayments(){

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.status','=','3')
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference as reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->get();

        return $payments;


//        return view('transactions.consumers.deposits',compact('deposits'));

    }

    public  function  reversedDeposits(){

        $deposits  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.status','=','3')
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.ncard_reference as reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }


    public  function  paymentsTransactions(){

//        $payments  =  DB::table('consumer_payments')
//            ->where('consumer_payments.status','=',1)
//            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
//                'consumer_payments.created_at','consumer_payments.recipient_id', 'consumer_payments.status','consumers.first_name','consumers.last_name')
//            ->join('consumers','consumers.id','consumer_payments.consumers_id')
//            ->get();

        $payments = ConsumerPayment::with('consumer')->with('merchant')->where('status', 1)
            ->join('bill_quantities','bill_quantities.payment_id','=','consumer_payments.id')
            ->get();

        return $payments;


    }

    public  function  paymentsHistory($consumer_wallet_id){

        $captureWalletIdException  =  ConsumerWallet::where('wallet_id',$consumer_wallet_id)->first();


        if (!$captureWalletIdException){

            $message  ='No resource Found ';
            return view('errors.resouce_not_found_exception',compact('message'));
        }

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.consumer_wallet_id',$consumer_wallet_id)
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference as reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->get();

        $fullName  =  DB::table('consumer_wallets')
            ->where('consumer_wallets.wallet_id',$consumer_wallet_id)
            ->select('consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_wallets.consumers_id')
            ->first();

        $fullName =   $fullName->first_name.' '.$fullName->last_name;

        $totalPayments  =  DB::table('consumer_payments')
            ->where('consumer_wallet_id',$consumer_wallet_id)
            ->sum('amount');

        return view('transactions.consumers.payments_history',compact('fullName','payments','totalPayments'));

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


    public  function  consumerDepositsApi(){


        $count =        Bank::count();

        $deposits  =    DB::table('banks')->skip(1)->take($count)->get();

        return  response()->json(['error'=>false,'count'=>$count,'data'=>$deposits]);
    }


    public  function  consumerDepositsApiUpdate(Request  $request){

        $count =        $request->get('count');

        $take =  Bank::count();

        if (empty($count)){

            $count =  0;
        }

        $deposits  =    DB::table('banks')->skip($count)->take($take)->get();

        $count =  Bank::count();

        return  response()->json(['error'=>false,'count'=>$count,'data'=>$deposits]);
    }



    public  function  feeCollectionTransactions(){

        $feeCollection  =  ConsumerPayment::with('feeCollection')->with('consumer')->get();

//        return response()->json($feeDisbursement);
        return view('transactions.fee_collection_account',compact('feeCollection'));




    }
}
