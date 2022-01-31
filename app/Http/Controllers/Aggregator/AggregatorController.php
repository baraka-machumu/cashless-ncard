<?php


namespace App\Http\Controllers\Aggregator;


use App\Gender;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\DeclareDeclare;

class AggregatorController extends  Controller
{

    public  function  index(){
        if (!Gate::allows('manage-agent')) {

            return view('errors.login_access');

        }
        $result  =  DB::select('call AAGetAllAggregatorSP');

        return view('aggregator.index',compact('result'));

    }

    public  function  create(){

        if (!Gate::allows('manage-agent')) {

            return view('errors.login_access');

        }

        $regions  =  DashboardController::getRegions();
        $genders  = Gender::all()->toArray();

        return view('aggregator.create',compact('regions','genders'));


    }

    public  function  save(Request  $request){

        if (!Gate::allows('manage-agent')) {

            return view('errors.login_access');

        }

        $name =  $request->name;
        $code=  $request->agent_code;
        $tin =  $request->tin;
        $location=  $request->location;
        $phone_number =  $request->phone_number;
        $email =  $request->email;
        $district_id=  $request->district_id;

        try {

            $result  =  DB::select('call AASaveAggregatorSP (?,?,?,?,?,?,?)',
                array($code,$name,$tin,$location,$phone_number,$email,$district_id));

//            dd($result[0]->resultcode);
            if ($result[0]->resultcode=='01'){

                Session::flash('alert-danger','Failed to save '.$result[0]->message);

                return   redirect()->back();

            }
//            dd($result[0]->resultcode);

            Session::flash('alert-info','Successful saved');

            return  redirect('aggregators');

        }catch (\Throwable $exception){

            Session::flash('alert-info','Successful saved '.$exception->getMessage());

//            dd(json_encode($exception->getMessage()));

         return   redirect()->back();

        }

    }

    public  function  view($code){

        $agent  = DB::select('call AAGetDetailsPerAggregatorCodeSP (?)',array($code));

//        dd($agent);

        if ($agent){

            $agent  =  $agent[0];
        }


        $account  = DB::select('call NcardGetAccountSP');

        return view('aggregator.show_agent',compact('code','agent','account'));

    }



}
