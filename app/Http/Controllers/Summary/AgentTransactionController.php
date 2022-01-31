<?php

namespace App\Http\Controllers\Summary;

use App\Exports\AgentSummaryExport;
use App\Exports\AgentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AgentTransactionController extends Controller
{


    public   function  index(Request $request){

        $agentCode  =  $request->agent_code;
        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;

        if ($agentCode!=null){

            $result= DB::select('call GetAgentTransactionByDateSP(?,?,?)',array($agentCode,$start_date,$end_date));

        }

        else {

            $result= DB::select('call GetAgentTransactionByDateSP(?,?,?)',array(null,$start_date,$end_date));

        }


        $agents  =  DB::table('agents')->select('agent_code','first_name','last_name')->get();


//                return response()->json($result);

        return view('summary.agents.agent_transactions',compact('agents','result','start_date','end_date'));

    }

    public  function  getAllConsumerRegisterPerAgent(Request $request,$agent_code){

        $start_date  =  $request->a_start_date;
        $end_date  =  $request->a_end_date;

        $result= DB::select('call GetAgentTransactionDetailsByDatePerAgentSP(?,?,?)',array($agent_code,$start_date,$end_date));

        $amount  = 0;
        foreach ($result as $row)
        {
            $amount += $row->amount;

        }


        return view('summary.agents.view_transactions',compact('amount','result','agent_code'));


    }

    public  function  export(Request $request){

        $start_date  =  $request->a_start_date;
        $end_date  =  $request->a_end_date;

        return Excel::download(new AgentTransaction($start_date,$end_date), 'agent-transaction-'.time().'.xlsx');

    }

}
