<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{

    public  function products($service_id){

       $result  =  DB::table('service_products')
            ->select('id','service_id','type','price','product_name')
            ->where(['service_id'=>$service_id])->get();

       return response()->json(['error'=>false,'data'=>$result]);

    }


    public function getMservices($tin){

        return DB::table('merchant_services as ms')
            ->join('services as s','s.id','=','ms.service_id')
            ->select('s.name','ms.id')
            ->where(['ms.tin'=>$tin])
            ->get();
    }


}
