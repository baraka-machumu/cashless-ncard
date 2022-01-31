<?php /** @noinspection PhpUnhandledExceptionInspection */


namespace App\Helper;


use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NameSearchApi
{


    public  static  function  getNameByPhoneNo($phoneNo){

        $phoneNumber  = self::addPrefix($phoneNo);

            $nameSearchApi  =  Config('api.name-search');

            $response = Http::post($nameSearchApi, [
                'msisdn' => $phoneNumber
            ]);

        if ($response->clientError()){

            throw new Exception('Client Error , invalid api');
        }
        if ($response->serverError()){

            throw new Exception('Sever Error , time out or server misconfiguration');
        }

        return $response;


    }


    public static function addPrefix($phone)
    {
        return preg_replace('/^0/','255',$phone);
    }
}
