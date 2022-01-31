<?php

namespace App\Http\Controllers\TicketEngine;

use App\ConsumerCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TicketEngineController extends Controller
{


    public  function  getTicketByCard (Request $request){

        $card_number  =  $request->consumer_card_number;
        $event_code  =  $request->eventCode;

        $consumer_card  =  ConsumerCard::query()->select('card_uid')->where(['card_number'=>$card_number])->first();

        $URL_TICKET  ='http://41.59.225.82:3001/lantana/v1/wbs/ticket-details';

        $requestBody  =

            [
                "CardUID"=>$consumer_card->card_uid,
                "EventCode"=>$event_code,
                'CardNumber'=>$card_number

            ];

        $dataFromApi  =   Http::post($URL_TICKET,$requestBody);

        $result  =  $dataFromApi->json();


//        return $result;

        if ($result['resultcode']=='01'){

            Session::flash('alert-warning',' '.strtoupper($result['message']));
            return back();

        }

        $resultP  =  false;

        return view('support.ticket', compact('result','resultP'));

//        return response()->json(['resultcode'=>0,'message'=>'success','data'=>$result]);


    }

    public  function  getSoldTickets(Request $request){



    }


    public  function  getTicketByPhoneNumber (Request $request){

        $phoneNo  =  $request->phoneNo;
        $event_code  =  $request->eventCode;


        $requestBody  =

            [
                "searchEntity"=>'phoneNo',
                "EventCode"=>$event_code,
                'PhoneNo'=>$phoneNo

            ];


        $dataFromApi  =   Http::post('http://41.59.225.82:3001/lantana/v1/wbs/search-ticket',$requestBody);

        $resultP  =  $dataFromApi->json();


        if ($resultP['resultcode']=='01'){

            Session::flash('alert-warning',' '.strtoupper($resultP['message']));
            return back();

        }

        $result  = false;

       // dd($resultP);

        return view('support.index', compact('resultP','result'));

    }


}
