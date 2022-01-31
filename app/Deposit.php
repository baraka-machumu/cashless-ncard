<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{


    public  static  function getDepositData($consumer_id){

        $consumer =  $users = Deposit::where('user_id',$consumer_id)->get()->toArray();

        return response()->json(['status'=>'1','result'=>$consumer]);

    }


}
