<?php

namespace App\Http\Controllers\Filter;

use App\Merchant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;

class FilterController extends Controller
{

    public  function  index(){

        $merchants  = Merchant::query()->get();

        $filterPeriod  = self::filterPeriod();

        $filterType = self::filterType();

        $result  = false; // initialize result to false , means no result from filter
        $r_cards  = false;

//        return response()->json($merchants);
        return view('general_filter.index',compact('r_cards','result','filterType','filterPeriod','merchants'));

    }

    public  function  getFilter(Request $request){

        $start_date =  $request->get('start_date');
        $end_date =  $request->get('end_date');
        $merchant =  $request->get('merchant');
        $filterPeriod=  $request->get('filterPeriod');
        $filterType=  $request->get('filterType');

        $result  = null;
        $r_cards  = false;
        if ($filterPeriod==200){

            $result =  self::RegisteredCards($filterPeriod);
//            return $result;
            $r_cards=  true;



        }


        $merchants  = Merchant::query()->get();

        $filterPeriod  = self::filterPeriod();

        $filterType = self::filterType();

//        return response()->json($result);
        return view('general_filter.index',compact('r_cards','result','filterType','filterPeriod','merchants'));


    }

    public  static  function  filterPeriod(){

        $filterPeriod = array(

            array('id'=>100,'description'=>'Custom Filter'),
            array('id'=>200,'description'=>'Daily'),
            array('id'=>300,'description'=>'Weekly'),
            array('id'=>400,'description'=>'Monthly'),

        );

        return $filterPeriod;

    }

    public  static  function  filterType(){

        $filterPeriod = array(
            array('id'=>1,'description'=>'Ticket sold'),
            array('id'=>0,'description'=>'Unsold Ticket'),
            array('id'=>300,'description'=>'Registered Card'),
            array('id'=>400,'description'=>'N Card Payment'),
            array('id'=>500,'description'=>'N Card Deposits'),

        );

        return $filterPeriod;

    }


    public  static  function RegisteredCards($period){


        if ($period ==200){



            $date  =  Carbon::today('Africa/Nairobi');

            $date= date('Y-m-d',strtotime($date));

            return  DB::select('call GetRegisteredCard(?)',array($date));

        }

    }


    public  static  function TicketSold($period,$filterType){


        if ($period ==100){

            $date  =  Carbon::today('Africa/Nairobi');

            $date= date('Y-m-d',strtotime($date));

            return  DB::select('call GetSoldTicketsSP(?,?)',array($date,$filterType));

        }

    }

}
