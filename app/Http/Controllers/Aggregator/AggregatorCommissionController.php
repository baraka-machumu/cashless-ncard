<?php


namespace App\Http\Controllers\Aggregator;


use App\Gender;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AggregatorCommissionController extends  Controller
{

    public  function  index($code){

        $result  =  DB::select('call AAGetCommissionSP(?)',array($code));

        return view('aggregator.commission.index',compact('result','code'));

    }

    public  function  create($code){


        $transaction_type_codes  = DB::table('transaction_type_codes')->get();


        return view('aggregator.commission.create',compact('code','transaction_type_codes'));

    }

    public  function  saveCommission(Request  $request,$code){


//        dd($request->all());

        $percentage  = $request->percentage;
        $trx_type  = $request->trx_type;
        $id  = Auth::user()->id;


        $result  =  DB::select('call AASaveCommissionSP (?,?,?,?)',array($percentage,$id,$code,$trx_type));

        if ($result[0]->resultcode=='01'){

            Session::flash('alert-danger','Failed to save '.$result[0]->message);

            return   redirect()->back();

        }

        Session::flash('alert-info','Successful saved');

        return  redirect('aggregators/set-commission/'.$code);



    }


}
