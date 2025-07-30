<?php

namespace App\Http\Controllers\Limit;

use App\Http\Controllers\Controller;
use App\ServiceNcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LimitController extends Controller
{
    public  function  index(){
        $limits  =  DB::table('limits')->select('id','class_name','created_at','daily_limit','balance_limit','credit_limit','debit_limit')->get();
        return view('limits.index',compact('limits'));
    }

    public  function store(Request  $request){
        $validator  =  Validator::make($request->all(),[
            'total_debit_per_day'=>'required|numeric',
            'class_name'=>'required|string',
            'balance_limit'=>'required',
            'debit_limit'=>'required|numeric',
            'credit_limit'=>'required|numeric'
        ]);

        if ($validator->fails()){
            Session::flash('alert-danger','Invalid input supplied');
            return  redirect('limits-class/create');
        }
        $daily_limit  = $request->total_debit_per_day;
        $class_name  = $request->class_name;
        $balance_limit  = $request->balance_limit;
        $debit_limit = $request->debit_limit;
        $credit_limit  = $request->credit_limit;
        $type = $request->limit_type;
        $user  =  Auth::user()->id;

        $limit  =  DB::table('limits')
            ->insert(
                    ['daily_limit'=>$daily_limit,
                    'class_name'=>$class_name,
                    'balance_limit'=>$balance_limit,
                    'type'=>$type,
                    'debit_limit'=>$debit_limit,
                    'credit_limit'=>$credit_limit,
                    'created_at'=>now('Nairobi'),
                    'created_by'=>$user]
            );
        if ($limit){
            Session::flash('alert-success','Successful created');

        }else{
            Session::flash('alert-danger','Failed to create limit');
        }
        return redirect('limits-class');
    }

    public  function update(Request  $request,$id){
        $daily_limit  = $request->daily_limit;
        $wallet_limit  = $request->wallet_limit;

        try {

            $user  =  Auth::user()->id;
            $id  = decrypt($id);
            $copyCurrentLimits  = DB::select('CALL CopyCurrentLimitToLogs(?)',[$id]);

            if ($copyCurrentLimits[0]->result_code!='00'){
                Session::flash('alert-danger','Failed to create limit');
                return redirect('limits-class');
            }

            $validator  =  Validator::make($request->all(),[
                'total_debit_per_day'=>'required|numeric|min:0',
                'class_name'=>'required|string',
                'balance_limit'=>'required|numeric|min:0',
                'debit_limit'=>'required|numeric|min:0',
                'credit_limit'=>'required|numeric|min:0'
            ]);

            if ($validator->fails()){
                Session::flash('alert-danger','Invalid input supplied');
                return  redirect('limits-class/create');
            }
            $daily_limit  = $request->total_debit_per_day;
            $class_name  = $request->class_name;
            $balance_limit  = $request->balance_limit;
            $debit_limit = $request->debit_limit;
            $credit_limit  = $request->credit_limit;
            $type = $request->type;
            $user  =  Auth::user()->id;

            $limit  =  DB::table('limits')
                ->insert(
                    ['daily_limit'=>$daily_limit,
                        'class_name'=>$class_name,
                        'balance_limit'=>$balance_limit,
                        'type'=>$type,
                        'debit_limit'=>$debit_limit,
                        'credit_limit'=>$credit_limit,
                        'created_by'=>$user]
                );
            if ($limit){

                Session::flash('alert-success','Successful created');

            }else{
                Session::flash('alert-danger','Failed to create limit');
            }

            return redirect('limits-class');

        }catch (\Throwable $exception){

            Log::error('LIMIT-ERROR',['MESSAGE'=>$exception]);
            Session::flash('alert-danger','Server error');
            return redirect('limits');

        }
    }

    public  function  create(){
        $code  =  random_int(10000,99999);
        $service  =  ServiceNcard::getAllServiceForLimit();
        $types = DB::table('limit_types')->select('code','name')->get();

        return view('limits.create',compact('code','service','types'));
    }

    public  function edit($id){
        $code  =  random_int(10000,99999);
        $service  =  ServiceNcard::getAllServiceForLimit();
        $types = DB::table('limit_types')->select('code','name')->get();

        $limit  =  DB::table('limits')
            ->select('id','class_name','created_at','balance_limit','type','credit_limit','debit_limit','daily_limit')
            ->where(['id'=>$id])
            ->first();

        return view('limits.edit',compact('code','service','types','limit'));
    }

}
