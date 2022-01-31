<?php

namespace App\Http\Controllers\Consumer;

use App\ConsumerCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConsumerHelperController extends Controller
{

    public  function  hasCard($consumer_wallet_id){

       $consumer_card  =  ConsumerCard::query()->select('card_number')
           ->where(['consumers_wallet_id'=>$consumer_wallet_id])->first();

       if ($consumer_card){
           return response()->json([
               'error'=>false,
               'card_number'=>$consumer_card->card_number
           ]);
       }
        return response()->json([
            'error'=>true,
            'card_number'=>'You don\'t have N card'
        ]);

    }
}
