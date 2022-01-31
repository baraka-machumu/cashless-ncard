<?php

namespace App\Http\Controllers\Summary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TicketSalesController extends Controller
{
    public  function  index(Request $request){
        $results = [];



        if (app()->environment()=='local'){

            $url = Config('api.TEST-TICKET');
        }

        else if(app()->environment()=='production'){

            $url =  Config('api.LIVE-TICKET');

        }
        $url  = 'http://41.59.225.82:3001/lantana/v1/wbs/sproviders';

        $service_providers  =  Http::get($url)->json();


        $result = false;

        return view('summary.ticket_sales',compact('result','results','service_providers'));
    }

    public  function  getSold(Request $request){


        $results = [];

        if (app()->environment()=='local'){

            $url =  Config('api.TEST-TICKET-WEB-PORTAL');
            $urllantana = Config('api.TEST-TICKET');

        }

        else if(app()->environment()=='production'){

            $url =  Config('api.LIVE-TICKET-WEB-PORTAL');
            $urllantana = Config('api.LIVE-TICKET');

        }
        $url  =$url.'/api/v1/Ticket-Engine/ticket-sales';


//         return $url;
        $result  = false;



        if (isset($_GET['submit'])){

            $result=  true;

            $results  =  Http::get($url,

                ['eventCode'=>$request->EventCode

                ])->json();
//        return  response()->json($results[0]['total_Collection']);

            $sum = 0;
            $total  = 0;
            foreach($results as $key=>$value){

                if(isset($value['total_Collection'])){

                    $sum += $value['total_Collection'];
                    $total += $value['Sold_Ticket'];

                }
            }
        }

//        return  response()->json($sum);

        $url  = $urllantana.'/lantana/v1/wbs/sproviders';

        $service_providers  =  Http::get($url)->json();

        return view('summary.ticket_sales',compact('result','total','sum','results','service_providers'));

    }

    public  function  getEventBymSCode($mscode){



        if (app()->environment()=='local'){

            $url =  Config('api.TEST-TICKET-WEB-PORTAL');
            $urllantana = Config('api.TEST-TICKET');
        }

        else if(app()->environment()=='production'){

            $url =  Config('api.LIVE-TICKET-WEB-PORTAL');
            $urllantana = Config('api.LIVE-TICKET');
        }

        $URL  = $urllantana.'/lantana/v1/wbs/events/'.$mscode;

//        dd($URL);

        $events  =  Http::get($URL)->json();

        return $events;

    }

    public  function  getMerchantCode($TinNo){


        // dd(Config('api.TEST-TICKET'));

        if (app()->environment()=='local'){

            $url =  Config('api.TEST-TICKET-WEB-PORTAL');
            $urllantana = Config('api.TEST-TICKET');
        }

        else if(app()->environment()=='production'){

            $url =  Config('api.LIVE-TICKET-WEB-PORTAL');
            $urllantana = Config('api.LIVE-TICKET');

        }

        $URL  = $urllantana.'/lantana/v1/wbs/services/'.$TinNo;

//         dd($URL);
        $events  =  Http::get($URL)->json();

        return $events;

    }

}
