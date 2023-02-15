<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

class CardHelper
{


    public  static  function  getCardNumberUsingVendorNumber($v_number){

        $res =  DB::table('cards')
            ->select('card_number')
            ->where('virtual_vendor_card_number','like','%'.$v_number.'%')
            ->first();

        if (!$res){
            return null;
        }

        return  $res->card_number;
    }
}
