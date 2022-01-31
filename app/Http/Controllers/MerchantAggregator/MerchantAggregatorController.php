<?php


namespace App\Http\Controllers\MerchantAggregator;


use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MerchantAggregatorController extends Controller
{

    public  function  index(){

        $result  =  DB::select('call MAGetAllSP');

//        dd($result);
        return view('merchant-aggregator.index',compact('result'));

    }


    public  function   create(){

        $result  = array();// DB::select('');

        $regions  =  DashboardController::getRegions();

        return view('merchant-aggregator.create',compact('result','regions'));

    }

    public  function  saveMA(Request  $request){

        $name =  $request->name;
        $tin =  $request->tin;
        $location=  $request->location;
        $phone_number =  $request->phone_number;
        $email =  $request->email;
        $district_id=  $request->district_id;

        $code  =  random_int(100000,999999);
        try {

            $userId = Auth::user()->id;

            $result  =  DB::select('call MASaveSP (?,?,?,?,?,?,?)',
                array($name,$tin,$location,$phone_number,$email,$code,$userId));

//            dd($result[0]->resultcode);
            if ($result[0]->resultcode=='01'){

                Session::flash('alert-danger','Failed to save '.$result[0]->message);

                return   redirect()->back();

            }
//            dd($result[0]->resultcode);

            Session::flash('alert-info','Successful saved');

            return  redirect('merchant-Aggregators');

        }catch (\Throwable $exception){

            Session::flash('alert-info','Successful saved '.$exception->getMessage());

//            dd(json_encode($exception->getMessage()));

            return   redirect()->back();

        }
    }

    public  function  view($code){

        $agent  = DB::select('call MAGetDetailsPerAggregatorCodeSP (?)',array($code));

        if ($agent){

            $agent  =  $agent[0];
        }


        return view('merchant-aggregator.show_agent',compact('code','agent'));

    }


}
