<?php


namespace App\Http\Controllers\Transaction;


use App\ConsumerCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TicketEngineTrnxController extends Controller
{


    public  function index(){

        $result  =  null;
        return view('transactions.ticket-engine.index',compact('result'));

    }



    public  function getTrnx(Request $request){


        try {
            $result = null;

            $card_number = $request->card_number;

            $card = ConsumerCard::query()->where(['card_number' => $card_number])->first();

            if (!$card) {

                Session::flash('alert-danger', 'No Card Number Found');

                return back();

            }

            $result = Http::post(base_url() . '/lantana/v1/wbs/attendancy-report',
                ['CardUID' => $card->card_uid, 'StartDate' => $request->start_date, 'EndDate' => $request->end_date]);

            $result = $result->json();


            if ($result['resultcode'] == '01') {

                $result = array();
                $sum = 0;

            } else {

                $result = json_decode(json_encode($result['result']));


                $sum = 0;
                foreach ($result as $key => $value) {
                    if (isset($value->Amount))
                        $sum += $value->Amount;
                }

            }
        }catch (\Throwable $exception){

            Session::flash('alert-danger','Processing Problem, please contact admin');
            return  back();
        }

        return view('transactions.ticket-engine.index',compact('result','sum','card_number'));

    }
}
