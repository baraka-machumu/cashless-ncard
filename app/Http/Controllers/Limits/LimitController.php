<?php

namespace App\Http\Controllers\Limits;

use App\Helper\AuditLogs;
use App\Helper\ExMessage;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\ApplicationRequest;
use App\CurrencyTypes;
use App\Limit;
use App\LimitApplication;
use App\LimitClass;
use App\LimitClassApplication;
use App\Service;
use App\Rules\NegativeValidation;
use App\ServiceNcard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\DeclareDeclare;

class LimitController extends Controller
{
    public  function  index(){
        $limits  = LimitClass::getLimitClass();
        return view('limits.index',compact('limits'));
    }
    public  function  create(){
        $code  =  random_int(10000,99999);
        $service  =  ServiceNcard::getAllServiceForLimit();
        $types = DB::table('limit_types')->select('code','name')->get();

        return view('limits.create',compact('code','service','types'));
    }
    public function  storeRuleEngine(Request  $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'max_daily' => 'required|numeric|min:0|not_in:0',
            'max_weekly' => 'required|numeric|min:0|not_in:0',
            'max_monthly' => 'required|numeric|min:0|not_in:0',
            'max_daily_no' => 'required|numeric|min:0|not_in:0' ,
            'max_weekly_no' => 'required|numeric|min:0|not_in:0',
            'max_monthly_no' => 'required|numeric|min:0|not_in:0',

        ]);

        if ($validator->fails()){


            return  response()->json(['result_code'=>'01','message'=>'Failed to validate request']);
        }

        Log::info('RULE-ENGINE',['MESSAGE'=>json_encode($request->all())]);
        $name  =  $request->class_name;
        $code  =  $request->class_code;
        $max_value  =  $request->max_account_value;
        $limitTypeCode   = $request->limitTypeCode;
        DB::beginTransaction();
        try {
            $limitPayment  =  new Limit();
            $limitPayment->class_limit_code = $code;
            $limitPayment->max_daily = $request->max_daily;;
            $limitPayment->max_weekly = $request->max_weekly;
            $limitPayment->max_monthly = $request->max_monthly;
            $limitPayment->daily_tx_no = $request->max_daily_no;;
            $limitPayment->weekly_tx_no = $request->max_weekly_no;
            $limitPayment->monthly_tx_no = $request->max_monthly_no;
            $limitPayment->created_by_id = Auth::user()->id;
            $limitPayment->limit_code = $request->service;
            $limitPayment->save();
            $desc  = "Save transaction rule set up with code".$code;
//            AuditLogs::save($desc,$code,'LIMITS','SAVE','SUCCESS','LIMITS');
            AuditLogs::saveLogs($desc,$code,'SAVE',$code);

            DB::commit();
            return  response()->json(['result_code'=>'00','message'=>'Limit Rules Successful Saved']);
        }
        catch (\Throwable $Throwable){
            Log::error($Throwable);
            return  response()->json(['result_code'=>'01','message'=>'Something went wrong']);
        }
    }


    public function  store(Request  $request){

        $validator = Validator::make($request->all(), [
            'class_name' => 'required|min:2|max:40',
            'class_code' => 'required|min:2|max:40',
            'max_account_value' => 'required|numeric|min:0|not_in:0'
        ]);

        if ($validator->fails()){
            Session::flash('alert-danger','Failed to validate request');
            return  response()->json(['result_code'=>'01','message'=> $validator->getMessageBag()->first()]);
        }

        $name  =  $request->class_name;
        $code  =  $request->class_code;
        $max_value  =  $request->max_account_value;
        $limitTypeCode   = $request->limitTypeCode;
        $currency = $request->currency;
        DB::beginTransaction();
        try {
            $class  = new LimitClass();
            $class->class_name  =$name;
            $class->class_code  =$code;
            $class->max_hold_amount =  $max_value;
            $class->created_by = Auth::user()->id;
            $class->currency =  $currency;
            $success = $class->save();
            if (!$success){
                return  response()->json(['result_code'=>'01','message'=>'Could not save, try again']);
            }
            $appId  =  RandomGenerator::referenceNumber($code);
            $app = ApplicationRequest::saveApplication($appId,'limit_class','LM001',
                $request->comment,$name ,$class->id);
            if (!$app){
                DB::rollBack();
                return  response()->json(['result_code'=>'01','message'=>'Could not save, try again']);
            }
            $desc  = "Save transaction Limit class ".$name;
//            AuditLogs::save($desc,$code,'LIMIT-CLASS','SAVE','SUCCESS','LIMIT-CLASS');
            AuditLogs::saveLogs($desc,$code,'SAVE',$code);

            DB::commit();
            return  response()->json(['result_code'=>'00','message'=>'Successful saved']);
        }
        catch (\Throwable $Throwable){
            DB::rollBack();
            Log::error($Throwable->getMessage());
            Log::error($Throwable);
            return  response()->json(['result_code'=>'01','message'=>'Something went wrong']);
        }
    }
    public  function  save(Request  $request){
        $limit  = new Limit();
        $limit->min = $request->min;
        $limit->max = $request->max;
        $limit->limit_code = $request->code;
        $limit->created_by_id  = Auth::user()->id;
        $limit->name  = $request->name;
        $success =  $limit->save();
        if ($success){
            Session::flash('alert-success','Successful saved');
        }
        else {
            Session::flash('alert-danger','Failed');
        }
        return redirect('limits');
    }
    public  function  view($id){
        $limitClass  =  LimitClass::limitClassPerId($id);
        $limits  = Limit::getLimits($limitClass->class_code);
        return view('limits.view',compact('id','limitClass','limits'));
    }

    public  function editLimit($id){
        $limit  = LimitClass::query()->where(['id'=>$id])->first();
        $status  = DB::table('duo_status')->get();
        $currency  = [];
        return view('limits.edit',compact('currency','id','limit','status'));
    }

    public function updateRuleEngine(Request  $request,$id){


        $validator = Validator::make($request->all(), [
            'class_name' => 'required|min:2|max:40',
            'class_code' => 'required|min:2|max:40',
            'max_account_value' => 'required|numeric|min:0|not_in:0'
        ]);

        if ($validator->fails()){

            Session::flash('alert-danger','Failed to validate request');
            return  back()->withInput();
        }

        $name  =  $request->class_name;
        $code  =  $request->class_code;
        $max_value  =  $request->max_account_value;
        $currency = $request->currency;
        DB::beginTransaction();
        try {
            $classLimit = LimitClass::query()->where(['id' => $id])->first();
            $appId = RandomGenerator::referenceNumber($classLimit->class_code);
            $class = new LimitClassApplication();
            $class->class_name = $name;
            $class->max_hold_amount = $max_value;
            $class->created_by = Auth::user()->id;
            $class->currency = $currency;
            $class->class_code = $classLimit->class_code;
            $class->status = $request->status;
            $success = $class->save();
            $app = ApplicationRequest::saveApplication($appId, 'limit_class', 'UPLM001',
                $request->comment, $name, $class->id);
            if ($success) {
                if (!$app) {
                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed');
                }
                $desc  = "Update transaction Limit rule ".$name;
                AuditLogs::save($desc,$code,'LIMIT-CLASS','SAVE','SUCCESS','LIMIT-CLASS');
                DB::commit();
                Session::flash('alert-success', 'Successful saved');
            }
            else {

                Session::flash('alert-danger', 'Failed');
            }

        }catch (\Throwable $Throwable){
            DB::rollBack();
            Log::error('LIMITS-ERROR',['MESSAGE'=>$Throwable]);
            Session::flash('alert-danger','something went wrong');
            return  back()->withInput();
        }
        return redirect('limits-class')->withInput();
    }
    public  function  editLimitItem($id){
        $limit  = Limit::query()->where(['id'=>$id])->first();
        $limitClass = LimitClass::query()->select('id')->where(['class_code'=>$limit->class_limit_code])->first();
        return view('limits.edit_limit_item',compact('id','limit','limitClass'));
    }
    /**
     * @param Request $request
     * @param $id
     * @param $class_id
     * @return RedirectResponse
     *
     * function that save limit rule for update
     */

    public  function  updateLimitItem(Request  $request,$id,$class_id): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'max_daily' => 'required|numeric|min:0|not_in:0',
            'max_weekly' => 'required|numeric|min:0|not_in:0',
            'max_monthly' => 'required|numeric|min:0|not_in:0',
            'max_daily_no' => 'required|numeric|min:0|not_in',
            'max_weekly_no' => 'required|numeric|min:0|not_in:0',
            'max_monthly_no' => 'required|numeric|min:0|not_in:0',

        ]);

        if ($validator->fails()){

            Session::flash('alert-danger','Failed to validate request');

            return back();
        }

        try {
            $limitClass =  LimitClass::query()->select('class_code','class_code')
                ->where(['id'=>$class_id])->first();
            $limit  = DB::table('limits as l')
                ->select('s.name','l.limit_code')
                ->join('services as s','s.tx_code','=','l.limit_code')
                ->where(['l.id'=>$id])->first();
            $limitApp  =  new LimitApplication();
            $limitApp->class_limit_code = $limitClass->class_code;
            $limitApp->max_daily = $request->max_daily;;
            $limitApp->max_weekly = $request->max_weekly;
            $limitApp->max_monthly = $request->max_monthly;
            $limitApp->daily_tx_no = $request->max_daily_no;;
            $limitApp->weekly_tx_no = $request->max_weekly_no;
            $limitApp->monthly_tx_no = $request->max_monthly_no;
            $limitApp->created_by_id = Auth::user()->id;
            $limitApp->limit_code = $limit->limit_code;
            $limitApp->limit_id = $id;
            $successLimit  =  $limitApp->save();
            if ($successLimit){
                $appId  =  RandomGenerator::referenceNumber($limitClass->class_code);
                $app = ApplicationRequest::saveApplication($appId,'limit_application','UPLMI001',
                    $request->comment,$limit->name ,$limitApp->id);
                if (!$app){
                    DB::rollBack();
                    Session::flash('alert-danger','Failed to save application');
                    return back();
                }
            }
            else{
                DB::rollBack();
                Session::flash('alert-danger','Failed to save application');
            }
            $desc  = "Update transaction Limit item ".$limitClass->class_code;
            AuditLogs::save($desc,$limitClass->class_code,'LIMITS','SAVE','SUCCESS','LIMITS');
            DB::commit();
            Session::flash('alert-success','Successful saved');
        }catch (\Throwable $Throwable){
            DB::rollBack();
            ExMessage::exp($Throwable);
            return back();
        }

        return  redirect('limits-class/'.$class_id);
    }

}
