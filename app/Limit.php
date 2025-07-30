<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Limit extends Model
{

    protected $table = 'limits';


    public  static  function  getLimits($limit_class_code){

     return   DB::table('limits as sl')
            ->select('sl.limit_code','sl.id','sl.max_daily','sl.max_weekly','sl.daily_tx_no','sl.weekly_tx_no',
                'sl.monthly_tx_no',
                'sl.max_monthly','sl.created_at','sl.name',
            'sl.limit_code','cc.name as limit_code_name','sl.id')
         ->join('services as cc','cc.tx_code','=','sl.limit_code')

         ->where(['sl.class_limit_code'=>$limit_class_code])
            ->get();

    }



}
