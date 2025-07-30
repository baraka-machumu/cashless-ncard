<?php

namespace App\Http\Controllers\Report;

use App\Exports\ConsumerTransactionByApp;
use App\Exports\ExportMerchantCollection;
use App\Http\Controllers\Controller;
use App\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PharIo\Manifest\RequiresElementTest;

class MerchantCollection extends Controller
{

    public  function  index(){

        $operation = null;

        $merchants  =  Merchant::query()->get();

        return view('reports.merchant_collection.index',compact('merchants','operation'));

    }

    public  function  getData(Request  $request)
    {
        ini_set('memory_limit','4048M');
        ini_set('max_execution_time', 120);
        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $tin  =  $request->tin;

        $operation = 'get';

        $merchants  =  Merchant::query()->get();

        return  Excel::download(new ExportMerchantCollection($start_date,$end_date,$tin),'Collection-'.time().'.xlsx');

        // return view('reports.merchant_collection.index',compact('merchants','operation','result','operation'));


    }

    public  function  export(Request  $request){

        try {

            $start_date  =  $request->a_start_date;
            $end_date  =  $request->a_end_date;
            $tin  =  $request->a_tin;

            return Excel::download(new ExportMerchantCollection($start_date,$end_date,$tin), 'consumer-app-transaction-'.time().'.xlsx');


        } catch (\Exception $exception){

            Session::flash('alert-danger','Server Error');
            return  back();
        }

    }


}
