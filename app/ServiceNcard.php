<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceNcard extends Model
{

    protected $table = 'service_ncard';

    public  static  function  getAllServiceForLimit(){
        $services = DB::table('service_ncard')->select('code','name')->get();
        return $services;
    }

}
