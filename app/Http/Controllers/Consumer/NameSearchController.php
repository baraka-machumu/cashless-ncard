<?php

namespace App\Http\Controllers\Consumer;

use App\Helper\NameSearchApi;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NameSearchController extends Controller
{

    public  function  nameSearch(Request $request){

        Log::channel('user-auth-log')->error('password reset request  '.json_encode($request->all()));

        $phoneNumber  = $request->get('phone_number');

        try {
            $result = NameSearchApi::getNameByPhoneNo($phoneNumber);


            if ($result['resultcode']==0){

                return response()->json(['error'=>false,'message'=>$result['message'],'data'=>$result['result']]);

            }
            return response()->json(['error'=>true,'message'=>$result['message'],'data'=>$result['result']]);

        }

        catch(Exception $exception){

            Log::channel('user-auth-log')->error('password reset request  '. $exception->getMessage());

            return response()->json(['error'=>true,'message'=>'Server Error, can not process your request']);

        }



    }
}
