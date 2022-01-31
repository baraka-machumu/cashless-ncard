<?php


namespace App\Http\Controllers\Report;


use App\Exports\ExportMnoTrnx;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public  static function  mnoTrnx($mno_id,$start_date,$ned_date){

        return Excel::download(new ExportMnoTrnx($mno_id,$start_date,$ned_date),'mno-trnx'.time().'.xlsx');


    }

}
