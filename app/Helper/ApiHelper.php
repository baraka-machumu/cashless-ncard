<?php


namespace App\Helper;


use App\Agent;
use App\AgentWallet;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiHelper
{


    public  static  function  getAgentBalance($msisdn =null){

        $client = new Client();

        $msisdn = '255734311880';

        $API_URL  = 'http://10.60.81.5:8092/kwava/bal';

        try {
            $result  =   $client->post($API_URL, [

                RequestOptions::JSON => ['msisdn' => $msisdn]

            ]);

            $data  =   json_decode($result->getBody(), true);

            return str_replace(',','',$data['balance']);
        }

        catch (ConnectException $exception){

            Log::channel('tx-agent-deposits')->error('error '.$exception);

        }

        catch (ClientException $exception){

            Log::channel('tx-agent-deposits')->error('error '.$exception);

        }

    }


    public static function  agentopup($utilityref,$cellid,$transid,$amount,$msisdn,$sender,$timestamp){

        $client   =  new Client();

        $SecretKey  = 'jBYIn7U8bfsNFPe6pPhXVKN3uq9PJfDQZPtU5dl26Y0=';

        $data_checksum =  $utilityref .'+' .$timestamp.'+' .$amount.'+'.$cellid.'+'.$transid.'+'.$msisdn.$SecretKey;

        $checksum  =base64_encode(hash('sha256',$data_checksum,true));

        $xml  =  self::xml($utilityref,$cellid,$transid,$amount,$msisdn,$sender,$timestamp,$checksum);

        try {
            $create = $client->request('POST', 'http://10.60.81.5:8096/kwava/pay', [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
                'body' => $xml
            ]);

            return response()->json($create);
        } catch (GuzzleException $e) {

            Log::channel('tx-payment')->error("TOP UP BY AGENT ERROR  ".$e);

        }


    }


    public  static  function  sendAgentTopup($Payload){

        $url  =  Config::get('api.API2_URL');

        $payload  = [
            "AgentCode"=>$Payload['agent_code'],
            "SuperAgentTIN"=>$Payload['super_agent'],
            "SlipPath"=>$Payload['slip_path'],
            "Amount"=>$Payload['amount'],
            "DepositedDate"=>date('Y-m-d h:i:s',strtotime($Payload['date'])),
            "SourceWalletNo"=>$Payload['source_wallet'],
            "DepositRefNo"=>$Payload['refNo'],
            "UserLoginID"=>Auth::user()->id,
            "RETRYTNX"=>$Payload['RETRYTNX']??0
        ];

        $result  = Http::post($url.'/agent/transactions/addBalance',$payload);

        Log::info('API2-RESPONSE',['MESSAGE'=>$result->json()]);
        return (json_decode($result));

    }


    public  static  function  sendAgentInfo($agent_code){

        $url  =  Config::get('api.API2_URL');

        $payload  =  Agent::query()->where(['agent_code'=>$agent_code])->first();

        $wallet  = AgentWallet::query()->select('pin')->where(['agents_code'=>$agent_code])->first();
        $body =
            [
                "AgentCode"=>$agent_code,
                "SuperAgentTIN"=>"123456",
                "AgentID"=>null,
                "FirstName"=>$payload->first_name,
                "MiddleName"=>$payload->middle_name,
                "LastName"=>$payload->last_name,
                "GenderID"=>$payload->gender_id,
                "DateOfBirth"=>'1970-01-01',
                "DistrictID"=>$payload->district_id,
                "PhoneNumber"=>$payload->phone_number,
                "Location"=>$payload->location,
                "StatusID"=>$payload->status_id,
                "Password"=>'1111222',
                "RegisteredDate"=>date('Y-m-d h:i:s',strtotime($payload->created_at)),
                "CanSellPaperTicket"=>$payload->can_sell_paper_ticket,
                "RegisteredByID"=>$payload->created_by,
                "WalletStatusID"=>1,
                "PIN"=>$wallet->pin,
                "Keyword"=>"INSERT"
            ];
        $result  = Http::post($url.'/agent/save-agent',$body);
        Log::info('API2-RESPONSE',['MESSAGE'=>$result->json()]);
        $result =  json_decode($result);

        $payload->api2_status = $result->resultCode;
        $payload->api2_message = $result->message;
        $payload->sent_to_api2  =1;
        $payload->save();

        return $result;
    }
}
