<?php

namespace App\Http\Controllers\Report;

use App\Agent;
use App\Gateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentCollectionController extends Controller
{

    public  function  index(Request  $request){

        $result  =  array();

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $agent_code  =  $request->agent_code;



        if (isset($_GET['_xt-get'])){

//            dd($agent_code);

            if (empty($agent_code)){

                $agent_code  = 'all';
            }

            $result  =  DB::select('call GET_AgentTopupSP(?,?,?)',array($start_date,$end_date,$agent_code));

//            return  response()->json($result);

            if (!$result){

                $result =  array();
            }
        }
        $agent  =  Agent::query()->get();

        return  view('reports.agent.index',compact('result','agent'));

    }

    public  function  getMnoCollection(Request $request){


        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $agent_code  =  $request->agent_code;

//        dd($agent_code);


        $agent  =  Agent::query()->get();


        if (!empty($agent)){

            $result  =  DB::select('call GET_AgentTopupSP(?,?,?)',array($start_date,$end_date,$agent_code));

            if (!$result){

                $result =  array();
            }
        }

        return  view('reports.agent.index',compact('result','agent'));

    }


}
