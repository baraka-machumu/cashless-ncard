<?php


namespace App\Http\Controllers\ApiHelper;


use Illuminate\Support\Facades\DB;

class PullFailedData
{

    public  static  function pullFailed(){

      $data  =      DB::table('bill_quantities as bq')->select('bq.product_id','bq.id as billId','bq.payment_id','cp.reference','cp.recipient_id','bq.quantity')
            ->join('consumer_payments as cp','cp.id','=','bq.payment_id')

          ->where(['bq.process_ticket_status'=>0,'is_failed'=>1])
            ->first();


        $category = null;
        if ($data->product_id  ==1){

            $category =  'A';
        } else if ($data->product_id ==2){

            $category = 'C';
        }

        $jsondata  = array(

            array(
                'id'=>$data->product_id,'category'=>$category,'quantity'=>$data->quantity
            )
        );

   return response()->json(['billId'=>$data->billId,'data'=>$jsondata,'reference'=>$data->reference,'tin'=>$data->recipient_id,'id'=>$data->payment_id]);

    }


}
