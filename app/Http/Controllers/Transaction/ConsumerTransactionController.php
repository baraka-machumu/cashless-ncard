<?php

namespace App\Http\Controllers\Transaction;


use App\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConsumerTransactionController extends Controller
{

    public  function index(){
        $result  =  [];
        $tnx_type = null;
        return view('transactions.consumers.index',compact('tnx_type','result'));

    }

    public  function  getTnx(Request  $request){

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $account =  $request->account;

        $tnx_type = $request->tnx_type;

        if (!empty($account)){
            $result  = DB::select('CALL GetConsumerTransactionByParamSPByWalletId (?,?,?,?)',array($start_date,$end_date,$account,$tnx_type));

        }else{
            $result  = DB::select('CALL GetConsumerTransactionByParamSP (?,?,?,?)',array($start_date,$end_date,$account,$tnx_type));

        }


        session()->flashInput($request->input());

        return view('transactions.consumers.index',compact('tnx_type','result'));
    }
}
