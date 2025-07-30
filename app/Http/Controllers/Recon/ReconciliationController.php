<?php

namespace App\Http\Controllers\Recon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ReconciliationController extends Controller
{

    public  function  check(Request $request){


        $is_result  = 1;
        $tin  = $request->tin;

        $date  =  $request->date;
        $merchants = DB::table('merchants')->select('name','tin')->get();

        $url  =  'http://41.59.225.82:3001/lantana/v1/wbs/general_reports';

        $res  =  Http::post($url,['StartDate'=>$date,'EndDate'=>$request->end_date,'TIN'=>$tin]);

        $res =  json_decode($res);

        Log::info('RES-RECON',['MESSAGE'=>$res]);

        $data  =  $res->result[0]??'';

        if (empty($data)){
            Session::flash('alert-danger','Problem with ticket engine api');
            return  redirect('reconciliation');
        }

        if (strtotime($date)<strtotime('2023-07-14')){

            $ncard_res  =  DB::connection('mysql_old')->select('CALL GetReconDataSP(?,?)',[$tin,$date,$request->end_date])[0];
//            if (strtotime($date)==strtotime('2023-07-14')){
//                $ncard_resR  =  DB::select('CALL GetReconDataSP(?,?)',[$tin,$date])[0];
//                $ncard_res->cTotal  = $ncard_res->cTotal+$ncard_resR->cTotal;
//                $ncard_res->cAmount  = $ncard_res->cAmount+$ncard_resR->cAmount;
//                $ncard_res->ATotal  = $ncard_res->ATotal+$ncard_resR->ATotal;
//                $ncard_res->AAmount  = $ncard_res->AAmount+$ncard_resR->AAmount;
//            }

        }
        else{

            $ncard_res  =  DB::select('CALL GetReconDataSP(?,?)',[$tin,$date,$request->end_date])[0];

        }

        $ncard_resTnx = $ncard_res;
        $dataEngine = $data;

        return view('recon.recon_today',compact('ncard_resTnx','dataEngine','merchants','date','is_result','ncard_res','date','data'));
    }

    public  function getTodayRecon(){

        $merchants = DB::table('merchants')->select('name','tin')->get();
        $is_result =0;
        return view('recon.recon_today',compact('merchants','is_result'));

    }

    public  function  requestControlNumber(){

    }

    public  function  pushMerchantPayment(){

    }
}
