<?php


namespace App\Http\Controllers\Card;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CardManagementController extends Controller
{

    public  function  index(Request $request){

        Log::info(json_encode($request->all()));

        return response()->json(['resultcode'=>0,'status_code'=>300,'message'=>'successful received','batch_no'=>1]);

    }

}
