<?php


namespace App\Http\Controllers\Aggregator;


use App\Gender;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AggregatorUserController extends  Controller
{

    public  function  index($agent_code){

        $result  =  DB::select('call AAGetAllAggregatorSP');

        return view('aggregator.users.index',compact('result','agent_code'));

    }

    public  function  create($agent_code){

        $regions  =  DashboardController::getRegions();
        $genders  = Gender::all()->toArray();

        return view('aggregator.users.create',compact('regions','genders','agent_code'));

    }

    public  function  store(Request  $request){

        $fullname  = $request->fullname;
        $password = Hash::make($request->password);
        $phone_number  = $request->phone_number;
        $email  = $request->email;
        $agent_code  = $request->agent_code;



        $result  =  DB::select('call AASaveAggregatorAgentUserSP(?,?,?,?,?',array($fullname));

        return view('aggregator.create',compact('result'));

    }


}
