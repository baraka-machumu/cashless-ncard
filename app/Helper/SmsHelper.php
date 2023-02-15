<?php


namespace App\Helper;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SmsHelper
{

    public static function sendSms($message,$phoneNumbers){

        $smsapi  =  Config('api.smsapi');

        try {

         $res  =    Http::post($smsapi,[
                    'msisdn' => $phoneNumbers,
                    'text' => $message,
                    'source'=>'N-CARD',
                    'reference'=>'onlinesite'
                ]
            );

            Log::channel('sms-send')->info('message '.$message.' sms sent to '.json_encode($phoneNumbers));

        }

        catch (ConnectException $exception){

            Log::channel('sms-send')->info(' sms  not sent to '.json_encode($phoneNumbers));

            return  response()->json(['error'=>true,'message'=>'No connection']);

        }

        catch (ClientException $exception){

            Log::channel('sms-send')->info(' sms  not sent to '.json_encode($phoneNumbers));

            return  response()->json(['error'=>true,'message'=>'No connection']);

        }

    }

    public  function  saveSms($data){
    DB::select('CALL SaveSmsSP(?,?)',[$data['message'],$data['phone_number']]);
    }

}
