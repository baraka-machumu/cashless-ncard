<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LimitClass extends Model
{

    protected $table='limit_class';


    public  static function getLimitClass(){

        return
        DB::table('limit_class')
            ->select('id','created_at','class_name','class_code','max_hold_amount')
            ->where(['status'=>'ACTIVE'])
            ->orderByDesc('id')
            ->get();

    }


    public  static  function limitClassPerId($id){

        return DB::table('limit_class as lc')
            ->select('ct.name as currency','lc.class_name','lc.created_at',
                'lc.max_hold_amount','lc.status','lc.class_code')
            ->join('currency_types as ct','ct.currency_code','=','lc.currency')
            ->where(['lc.id'=>$id])->first();
    }

}
