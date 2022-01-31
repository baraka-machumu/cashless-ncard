<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AgentDepositController extends Controller
{

    public  function  deposits(){

        $deposits  =  DB::table('agent_deposits as d')
            ->select('d.agent_wallet_id','d.amount','d.reference','d.created_at',
                'first_name','last_name','phone_number')
            ->join('agents as a','a.agent_code','=','d.agent_wallet_id')
            ->get();

//        return response()->json($deposits);

        return view('agent_deposits.index',compact('deposits'));

    }

    public  function getAgentDepositByOptions(Request $request){


        $search_option_query  =  $request->search_option_query;

        if (strlen($search_option_query)==6){

            $phone_number =  null;
            $agent_wallet_id =  $search_option_query;
        } else{

            $phone_number =  $search_option_query;
            $agent_wallet_id =  null;
        }

        $deposits  =  DB::table('agent_deposits as d');

        if (!empty($phone_number)){


            $deposits = $deposits->where(['phone_number'=>$phone_number]);

        }
        else if(!empty($agent_wallet_id)){


            $deposits = $deposits->where(['agent_wallet_id'=>$agent_wallet_id]);

        }

        $deposits  = $deposits->select('d.agent_wallet_id','d.amount','d.reference','d.created_at',
            'first_name','last_name','phone_number')
            ->join('agents as a','a.agent_code','=','d.agent_wallet_id')
            ->get();

        if (empty($deposits)){

            Session::flash('alert-warning','No record found');
        }

        else {

            Session::flash('alert-success','Found');

        }
//        return response()->json($deposits);

        return view('agent_deposits.index',compact('deposits'));


    }


}
