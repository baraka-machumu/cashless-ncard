<?php

namespace App\Http\Controllers\Transaction;

use App\Exports\TnxVerifyExport;
use App\Http\Controllers\Controller;
use App\Imports\ImportDisbursement;
use App\Imports\TnxVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TnxVerifyController extends Controller
{

    public  function  index(){

        $res  =  DB::table('tnx_verify')->get();
        return view('transactions.verify',compact('res'));
    }

    public  function  store(Request  $request){
//        ini_set('upload_max_filesize', '600M');
//        ini_set('max_execution_time', '999');
//        ini_set('memory_limit', '256');
//        ini_set('post_max_size', '600M');
        $validator = Validator::make(
            [
                'tnx'=> $request->tnx,
            ],
            [
                'tnx'=>'required|mimes:xlsx,xls',
            ]
        );

        if ($validator->fails()){
            Session::flash('alert-warning',' Please Upload a valid Excel file '.$validator->errors());
            return redirect('tnx-recon/verify');
        }

        DB::table('tnx_verify')->truncate();
        DB::beginTransaction();

        try {

            Excel::import(new TnxVerify(), request()->file('tnx'));
            Session::flash('alert-success','Imported Successfully');
            DB::commit();
            return redirect('tnx-recon/verify');

        }catch (\Throwable $exception){
            Log::error('VERIFY-ERROR',['MESSAGE'=>$exception]);
            Session::flash('alert-warning','Server Error');
            return redirect('tnx-recon/verify');

        }
    }

    public  function  checkStatus(){

        set_time_limit(3600);
        ini_set('memory_limit','2048M');

        $res  =  DB::table('tnx_verify')->get();
        foreach ($res as $row){

            $ref  =  preg_replace('/\s+/', '', $row->channel_ref_no);

//            dd($ref);

            $check_tnx  = DB::table('consumer_deposits')
                ->where(['source_ref'=>$ref])->first();

            if ($check_tnx){
                DB::table('tnx_verify')->where(['channel_ref_no'=>$ref])
                    ->update(['status'=>'SUCCESSFUL']);
            }
            else{
                DB::table('tnx_verify')->where(['channel_ref_no'=>$ref])
                    ->update(['status'=>'NOT FOUND']);
            }
        }

        return redirect('tnx-recon/verify');

    }


    public  function  download(){

        return Excel::download(new TnxVerifyExport, 'tnx-verify-'.time().'.xlsx');

    }


}
