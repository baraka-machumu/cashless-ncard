<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SellTicketController extends Controller
{


    public  function  sellView(Request $request){


        return view('');

    }


        public  function  sell(Request $request){


        $TICKET_BASE_POINT= 'http://41.59.225.82:3001/lantana/v1/wbs/purchase-ticket';

        $requestBody  =    [
            "EventCode"=>'SM001',
            "PhoneNumber"=>$request->phone_number,
            "CardUID"=>$request->card_number,
            "Amount"=>$request->amount,
            "PriceCode"=>'V01',
            "ChannelCode"=>"1",
            "walletId"=>$request->phone_number,
            "CategoryCode"=>'0017'

        ];

        $dataFromApi  =   Http::post($TICKET_BASE_POINT,$requestBody);

        $result  =  $dataFromApi->json();

    }
}
