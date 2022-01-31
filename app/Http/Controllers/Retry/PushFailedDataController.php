<?php

namespace App\Http\Controllers\Retry;

use App\Helper\PaymentHelper;
use App\Http\Controllers\ApiHelper\PullFailedData;
use App\Jobs\ProcessTicketJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushFailedDataController extends Controller
{


    public  function pushFailed(Request $request){

        PaymentHelper::getTicket($request->cat,$request->idadi);

//        ProcessTicketJob::dispatch ($cat,$idadi);

//        for ($i=0; $i<10; $i++) {

//            $result = PullFailedData::pullFailed()->getData(true);

           // sleep(10);
//        return $result;
//      $result['billId'];  ProcessTicketJob::dispatch

//            PaymentHelper::getTicket()
//            ProcessTicketJob::dispatch ($result['data'], $result['reference'], $result['tin'], $result['id'], $result['billId']);

//            return "success";
//        }
    }
}
