<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use App\Exports\AgentSummaryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AgentSummaryController extends Controller
{


    public   function  index(Request $request){

        $agentCode  =  $request->agent_code;
        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;

        if ($agentCode!=null){

            $result= DB::select('call GetAgentSummarySp(?,?,?)',array($agentCode,$start_date,$end_date));

        }

        else {

            $result= DB::select('call GetAgentSummarySp(?,?,?)',array(null,$start_date,$end_date));

        }

//        return response()->json($result);

        $agents  =  DB::table('agents')->select('agent_code','first_name','last_name')->get();

        $request_for_export = [
            'agent_code' => ($agentCode == null) ? 'default' : $agentCode ,
                'start_date' => $start_date,
                'end_date' => $end_date,
        ];
        return view('summary.agents.index',compact('agents','result','request_for_export'));

    }

    public function exportAgentSummary($agent_code,$start_date,$end_date)
    {
        return Excel::download(new AgentSummaryExport($agent_code,$start_date,$end_date), 'agents_summary.xlsx');
    }


    public  function  getAllConsumerRegisterPerAgent($agent_code){

        $result= DB::select('call GetAllRegisteredCardPerAgentSP(?)',array($agent_code,));

        return view('summary.agents.view_cards',compact('result','agent_code'));

    }

}
