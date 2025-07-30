<?php

namespace App\Http\Controllers\Transaction;


use App\Agent;
use App\Exports\AgentTransactionByDate;
use App\Exports\CustomerTransactionByDate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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
        if ($request->get('export_search')=='export'){

         return   Excel::download(new CustomerTransactionByDate($result),'tnx-data-'.time().'.xlsx');
        }

        session()->flashInput($request->input());

        return view('transactions.consumers.index',compact('tnx_type','result'));
    }


    public  function view($id,$tnx_type){
        $result  =  DB::select('CALL GetConsumerCreditTnxSPByWalletIdDetails(?,?)',[$id,$tnx_type])[0];

        return view('transactions.consumers.view',compact('tnx_type','result','id'));

    }



    public  function  getTnxApi(Request  $request){
        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $account =  $request->account;
        $tnx_type = $request->tnx_type;

        $result  = DB::select('CALL GetDefaultConsumerTransactionByParamSPByWalletId (?)',array($account));
        Log::info('INFO',['MESSAGE'=>$result]);
        return response()->json($result);

    }
}
