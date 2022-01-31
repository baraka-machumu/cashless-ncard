<?php

namespace App\Http\Controllers\Report;

use App\Gateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MnoCollectionController extends Controller
{

    public  function  index(Request  $request){

//        $result  =  null;

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;

        $mno  =  Gateway::query()->get();

        $result  =  DB::select('call GET_MNOTopupSP(?,?)',array($start_date,$end_date));

        return  view('reports.mno.index',compact('result','mno'));

    }

    public  function  getMnoCollection(Request $request){

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;

        $mno  =  Gateway::query()->get();

        $result  =  DB::select('call GET_MNOTopupSP(?,?,?)',array($start_date,$end_date));

        return  view('reports.mno.index',compact('mno','start_date','end_date','result'));
    }




    public  function  mnoTrnx(Request  $request){

        $result  =  null;

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $mno_id =  $request->mno_id;

        $mno  =  Gateway::query()->get();

        if (!empty($mno_id)){

            return  ExportController::mnoTrnx($mno_id,$start_date,$end_date);
        }

        return  view('reports.mno.trnx',compact('result','mno'));

    }
}
