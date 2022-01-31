<?php


namespace App\Http\Controllers\Report;


use App\Exports\ExportRevenueDataAllMerchant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class DailyTransactionReportController extends Controller
{

    public  function  index(){

        $is_result  = false;

        return view('reports.transactions.daily',compact('is_result'));

    }


    public  function  getTransactionReport(Request  $request){

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $is_result  = true;

        $result  = DB::select('call GetDailyTransactionsSP(?,?)',array($start_date,$end_date));

        return view('reports.transactions.daily',compact('start_date','end_date','is_result','result'));


    }

    public  function  exportToExcel(Request  $request){

        $data  = json_decode($request->data);

        $date_from = $request->a_start_date;
        $date_to= $request->a_end_date;

        return \Maatwebsite\Excel\Facades\
        Excel::download(new ExportRevenueDataAllMerchant($data,$date_from,$date_to),'revenue-'.time().'.xlsx');

    }


}
