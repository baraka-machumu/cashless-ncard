<?php

namespace App\Http\Controllers\Summary;

use App\Exports\AgentTransaction;
use App\Exports\ConsumerTransactionByApp;
use App\Http\Controllers\Controller;
use App\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ConsumerTransactionController extends Controller
{


    public   function  index(Request $request){

        $consumer_wallet_id  =  $request->consumer_wallet_id;
        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $tin  =  $request->tin;


        $result  = array();

        if (isset($_GET['repo-btn'])){

            $result= DB::select('call GetConsumerTransactionByMobileApp(?,?,?,?)',array($start_date,$end_date,$tin,10));


        }


        $merchants  =  Merchant::query()->select('tin','name')->get();


        return view('summary.consumers.consumer_transactions',compact('result','start_date','end_date','merchants','tin'));

    }

    public  function  getAllConsumerRegisterPerConsumer(Request $request,$agent_code){

        $start_date  =  $request->a_start_date;
        $end_date  =  $request->a_end_date;

        $result= DB::select('call GetAgentTransactionDetailsByDatePerAgentSP(?,?,?)',array($agent_code,$start_date,$end_date));

        $amount  = 0;

        foreach ($result as $row)
        {

            $amount += $row->amount;

        }

        return view('summary.consumer.consumer_transactions',compact('amount','result','agent_code'));

    }


    public  function  export(Request $request){

        $start_date  =  $request->a_start_date;
        $end_date  =  $request->a_end_date;

        $tin  = $request->a_tin;




        return Excel::download(new ConsumerTransactionByApp($start_date,$end_date,$tin), 'consumer-app-transaction-'.time().'.xlsx');



    }
}
