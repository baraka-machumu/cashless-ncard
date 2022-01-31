<?php


namespace App\Http\Controllers\ApiHelper;


use Illuminate\Support\Facades\Http;

class PushGovernmentPayment
{


    public  static  function sendRequestTPESA($data){


        $amount  =  $data['amount'];
        $date  =  $data['date'];
        $merchant  =  $data['merchant'];
        $controlNo  = $data['controlNumber'];
        $approver  =  $data['approver'];


        $response  =  Http::post('http://localhost/payment',
            [

            ]);

        if ($response['resultcode'==0]){

        }

        else if($response['resultcode'=='01']){


        }




    }

}
