<?php

namespace App\Http\Controllers;

use App\Imports\ExcelBalance;
use App\Imports\ImportDisbursement;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public  function  excel(){

        return view('excel');

    }

    public  function  save(Request  $request){

        $validator = Validator::make(
            [
                'file'=> $request->file

            ],
            [
            ]
        );

        if ($validator->fails()){

            Session::flash('alert-warning',' Please Upload a valid Excel file '.$validator->errors());
            return redirect('excel-top-up');

        }

        try {


            DB::beginTransaction();

            Excel::import(new ExcelBalance(), request()->file('file'));

            DB::commit();

            Session::flash('alert-success','Imported Successfully');
            return redirect('excel-top-up');


        }catch (\Throwable $exception){

            DB::rollBack();
            Session::flash('alert-success','Server error '.$exception->getMessage());

            return redirect('excel-top-up');

        }

    }


}
