<?php

namespace App\Http\Controllers\Transaction;

use App\Agent;
use App\AgentWallet;
use App\ConsumerDeposit;
use App\ConsumerWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AgentTransactionController extends Controller
{

    public function  index(){


        $deposits  = $this->depositTransactions();


        $payments  =  $this->paymentsTransactions();

//        return response()->json($payments);
        $failedDeposits   =  $this->failedDeposits();
        $reversedDeposits =  $this->reversedDeposits();
        $failedPayments =  $this->failedPayments();
        $reversedPayments =  $this->reversedPayments();

        return view('transactions.agents.tab',compact('reversedPayments','failedPayments','failedDeposits','reversedDeposits','deposits','payments'));

    }

    public  function  history($agent_code){

//        $agentData  = Agent::find($agent_code)->with('wallet')->first();
//
//        return response()->json($agentData);



        $depositPerAgent = $this->depositPerAgent($agent_code);

        $failedDepositsPerAgent = $this->failedDepositsPerAgent($agent_code);

        $reversedDepositsPerAgent =  $this->reversedDepositsPerAgent($agent_code);

        $paymentPerAgent =  $this->paymentsTransactionsPerAgent($agent_code);





        return view('transactions.agents.history.tab',compact('paymentPerAgent','agent_code','depositPerAgent','failedDepositsPerAgent','reversedDepositsPerAgent'));

    }

    public  function  depositTransactions(){

        $deposits  =  DB::table('agent_deposits')
            ->where('agent_deposits.status','=','1')
            ->select('agent_deposits.amount','agent_deposits.agent_wallet_id','agent_deposits.reference',
                'agent_deposits.created_at', 'agent_deposits.status','agents.first_name','agents.last_name')
            ->join('agents','agents.agent_code','agent_deposits.agent_wallet_id')

            ->latest()->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }

    public  function  failedDeposits(){

        $failed  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.status','=','0')
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->latest()->get();

        return $failed;

    }

    public  function  payments(){

        $payments  =  DB::table('consumer_payments')
            ->where(['consumer_payments.status'=>1,'consumer_payments.recipient_type'=>2])
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->latest()->get();

        return $payments;


    }


    public  function  failedPayments(){

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.status','=','0')
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->latest()->get();

        return $payments;


    }

    public  function  reversedPayments(){

        $payments  =  DB::table('consumer_payments')
            ->where('consumer_payments.status','=','3')
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->latest()->get();

        return $payments;


//        return view('transactions.consumers.deposits',compact('deposits'));

    }

    public  function  reversedDeposits(){

        $deposits  =  DB::table('consumer_deposits')
            ->where('consumer_deposits.status','=','3')
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->latest()->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }


    public  function  paymentsTransactions(){

        $payments  = DB::table('consumer_deposits')
            ->where(['consumer_deposits.status'=>1,'consumer_deposits.gateway_type'=>2])
            ->select('consumer_deposits.gateway_id as agent_code','consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')

            ->latest()->get();


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
            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
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
            ->select('consumer_deposits.amount','consumer_deposits.consumer_wallet_id','consumer_deposits.reference',
                'consumer_deposits.created_at', 'consumer_deposits.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_deposits.consumers_id')
            ->latest()->get();
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



    // deposits per agents start here
    public  function  depositPerAgent($agent_code){

        $deposits  = DB::table('agent_deposits')
            ->where(['agent_deposits.status'=>1,'agent_wallet_id'=>$agent_code])
            ->select('agent_deposits.amount','agent_deposits.reference',
                'agent_deposits.created_at', 'agent_deposits.status','banks.name','bank_branches.name')
            ->join('banks','banks.id','agent_deposits.bank')
            ->join('bank_branches','bank_branches.id','agent_deposits.branch')
            ->latest()->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }
    public  function  failedDepositsPerAgent($agent_code){

        $failed  =  DB::table('agent_deposits')
            ->where(['agent_deposits.status'=>0,'agent_wallet_id'=>$agent_code])
            ->select('agent_deposits.amount','agent_deposits.reference',
                'agent_deposits.created_at', 'agent_deposits.status','banks.name','bank_branches.name')
            ->join('banks','banks.id','agent_deposits.bank')
            ->join('bank_branches','bank_branches.id','agent_deposits.branch')
            ->latest()->get();

        return $failed;
    }

    public  function  reversedDepositsPerAgent($agent_code){

        $deposits  = DB::table('agent_deposits')
            ->where(['agent_deposits.status'=>3,'agent_wallet_id'=>$agent_code])
            ->select('agent_deposits.amount','agent_deposits.reference',
                'agent_deposits.created_at', 'agent_deposits.status','banks.name','bank_branches.name')
            ->join('banks','banks.id','agent_deposits.bank')
            ->join('bank_branches','bank_branches.id','agent_deposits.branch')
            ->latest()->get();

        return $deposits;

//        return view('transactions.consumers.deposits',compact('deposits'));

    }

    public  function  paymentsTransactionsPerAgent($agent_code){

        $payments  =  DB::table('consumer_payments')
            ->where(['consumer_payments.status'=>1,'consumer_payments.recipient_type'=>2,'recipient_id'=>$agent_code])

            ->select('consumer_payments.amount','consumer_payments.consumer_wallet_id','consumer_payments.reference',
                'consumer_payments.created_at', 'consumer_payments.status','consumers.first_name','consumers.last_name')
            ->join('consumers','consumers.id','consumer_payments.consumers_id')
            ->latest()->get();

        return $payments;

    }

    public  function  AgentdisbursementTransactions(){


        $feeDisbursement  =  ConsumerDeposit::with('consumerFeeDisbursement')->with('consumer')->get();

//        return response()->json($feeDisbursement);
        return view('transactions.agents.agent_disbursement_account',compact('feeDisbursement'));

    }
}
