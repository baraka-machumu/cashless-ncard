<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConsumerActivityController extends Controller
{


    public  function  getAllConsumerPayments($wallet_id){

        $data  =  DB::table('consumer_payments as cp')
            ->select('cp.created_at','m.name as merchant','bq.quantity','bq.total_price','sp.product_name')
            ->join('merchants as m','m.tin','=','cp.recipient_id')
            ->join('bill_quantities as bq','bq.payment_id','=','cp.id')
            ->join('service_products as sp','sp.id','=','bq.product_id')

            ->where(['recipient_type'=>3,'consumer_wallet_id'=>$wallet_id])
            ->latest('cp.created_at')->get();

        return response()->json($data);

    }

    public  function  getAllConsumerDeposits($wallet_id){



        $data  =  DB::table('consumer_deposits as cd')
            ->select('mdn','cd.created_at',
                DB::raw('(CASE WHEN cd.gateway_type =1 THEN g.name WHEN cd.gateway_type =2 THEN CONCAT(ag.first_name ,"",ag.last_name) END) as gateway_name'),
                'cd.amount')
            ->leftJoin('gateways as g','g.id','=','cd.gateway_id')
            ->leftJoin('agents as ag','ag.agent_code','=','cd.gateway_id')
            ->where(['consumer_wallet_id'=>$wallet_id])
            ->latest('cd.created_at')->get();
        return response()->json($data);

    }

}
