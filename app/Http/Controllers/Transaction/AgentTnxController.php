<?php

namespace App\Http\Controllers\Transaction;

use App\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentTnxController extends Controller
{
    public  function  index(){
        $agent  =  Agent::query()->get();
        $result  =  [];

        $tnx_type = null;
        return view('transactions.agents.index',compact('tnx_type','agent','result'));

    }

    public  function  getTnx(Request  $request){
        $agent  =  Agent::query()->get();

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;


        $agent_code  =  $request->agent_code;

        if (!empty($request->a_code)){
            $agent_code = $request->a_code;
        }

        $tnx_type = $request->tnx_type;
        if ($tnx_type=='C'){
            $result  = DB::select('CALL GetAgentCreditSP (?,?,?)',array($agent_code,$start_date,$end_date));

        }else{
            $result  = DB::select('CALL GetAgentDebitSP (?,?,?)',array($agent_code,$start_date,$end_date));

        }
        session()->flashInput($request->input());

        return view('transactions.agents.index',compact('tnx_type','agent','result'));
    }

    public  function  print(Request  $request,$tnx_id){


    }

    public  function  viewTxLogs($txId){

        $result  = DB::select('call PortalViewAgentLogsTnxById(?)',[$txId])[0];

        return view('transactions.agents.view_tx_logs',compact('result'));
    }
}
