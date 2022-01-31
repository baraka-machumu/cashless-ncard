<?php

namespace App\Http\Controllers\ApiHelper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ManageTopupController extends Controller
{

    public  function  manageTopup(){


        try {
            $data = json_decode(file_get_contents("php://input"));

//            return response()->json([44]);
            $walletCheckPrefix = strtoupper(substr($data->wallet_id, 0, 2));

//            return $walletCheckPrefix;
            if ($walletCheckPrefix =='NC') {


                return ConsumerTopup::storeDeposit($data);

            } else {

                return AgentTopUp::storeTopup($data);
            }

        } catch (\Exception $exception){

            return response()->json(['resultcode'=>1,'message'=>'Bad request from server '.$exception->getMessage()]);
        }


    }


    public  function  getAgentBalance($msisdn =null){

        $msisdn = '255734311880';

        $client = new Client();
        $API_URL  = 'http://10.60.81.5:8092/kwava/bal';

        try {
            $result  =   $client->post($API_URL, [

                RequestOptions::JSON => ['msisdn' => $msisdn]

            ]);

            $data  =   json_decode($result->getBody(), true);

            return $data['balance'];

        }

        catch (ConnectException $exception){

            Log::channel('tx-agent-deposits')->error('error '.$exception);

        }

        catch (ClientException $exception){

            Log::channel('tx-agent-deposits')->error('error '.$exception);

        }





    }
}
