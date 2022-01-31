<?php


namespace App\Http\Controllers\Agent;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AgentActivityController extends Controller
{

    public  function  index(){

        return view('agents.activity.index');

    }

    public  static  function  getData($agentCode){

        $result =  DB::select('call GetAgentStatementReport(?)',array($agentCode));

        return $result[0];

    }

    public  function reOpenActivity($agent_code){


        $res = DB::select('call OpenActivitySP(?)',array($agent_code));
        $error  = 'danger';

        if ($res[0]->result_code='00'){

            $error  = 'success';
        }

        Session::flash('alert-'.$error,''.$res[0]->message);

        return back();
    }

}
