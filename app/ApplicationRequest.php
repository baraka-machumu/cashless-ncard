<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ApplicationRequest extends Model
{

    protected $table = 'applications';
    public  static  function  saveApplication($appId,$table_name,$application_type,
                                              $comment=null,$account=null,$itemId=null,$service=null){
        $operation = 'CREATION';
        if(substr($application_type,0,2)=='UP'){

            $operation = 'UPDATE';

        }

        $app  = new ApplicationRequest();

        $app->application_code  =  $appId;
        $app->table_name  =  $table_name;
        $app->created_by  =  Auth::user()->id;
        $app->comment  =  $comment;
        $app->application_type  =  $application_type;
        $app->account  = $account;
        $app->general_comment  = $comment;
        $app->service =$service;
        if ($application_type!='BLKAD001'){
            $app->item_id  = $itemId;
        }else{
            $app->is_bulk_upload  = 1;
        }
        $app->operation =  $operation;

        $app->save();

        return $app;

    }

    public  static  function getAppPerId($id,$on_queue=null){
        $result  =   DB::table('applications as ap')
            ->select('ap.error_message','ap.operation','ap.id','ap.item_id','ap.account','ap.action_status','ap.id','ap.created_at','u.first_name',
                'u.last_name','at.name as application_name','ap.application_type','u.middle_name','ap.user_branch_code','application_code')
            ->leftJoin('application_type as at','at.code','=','ap.application_type')
            ->leftJoin('users as u','u.id','=','ap.created_by');

        if ($on_queue){

            $result =$result->where(['ap.id'=>$id])
                            ->whereIn('ap.status',['01','00']);
        }else{
            $result =$result->where(['ap.status'=>'01','ap.id'=>$id]);

        }

        $result=$result->first();

        if (!$result){
            Log::error('NO DATA FOUND FOR APP ID '.$id);
            return ['ERROR'=>'NOT_DATA_FOUND'];
        }

        if ($on_queue==null){

            $branch  = Auth::user()->branch??null;

            if ($result->user_branch_code!=$branch){

                Session::flash('alert-danger','Invalid access');
                return view('errors.login_access');
            }
        }
        return $result;
    }
}
