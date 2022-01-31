<?php


namespace App\Helper;


use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Auth\Events\Logout;
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


    public  static function  xml($utilityref,$cellid,$transid,$amount,$msisdn,$sender,$timestamp,$checksum){

        /**
         * ceiid ni pos  number
         */
        $xml  =  "<?xml version='1.0'?>
<methodCall>
    <methodName>KWAVA.Pay</methodName>
    <params>
        <param>
            <value>
                <struct>
                
                     <member>
                        <name>pin</name>
                        <value>
                            <string>1234</string>
                        </value>
                    </member>
                    
                    <member>
                        <name>vendor</name>
                        <value>
                            <string>CASHLESS</string>
                        </value>
                    </member>
                    <member>
                        <name>utilitycode</name>
                        <value>
                            <string>PESAMTANDAO</string>
                        </value>
                    </member>
                    <member>
                        <name>utilityref</name>
                        <value>
                            <string>$utilityref</string>
                        </value>
                    </member>
                    <member>
                        <name>cellid</name>
                        <value>
                            <string>$cellid</string>
                        </value>
                    </member>
                    <member>
                        <name>transid</name>
                        <value>
                            <string>$transid</string>
                        </value>
                    </member>
                    <member>
                        <name>amount</name>
                        <value>
                            <string>$amount</string>
                        </value>
                    </member>
                    <member>
                        <name>msisdn</name>
                        <value>
                            <string>$msisdn</string>
                        </value>
                    </member>
                    <member>
                        <name>sender</name>
                        <value>
                            <string>$sender</string>
                        </value>
                    </member>
                    <member>
                        <name>timestamp</name>
                        <value>
                            <string>$timestamp</string>
                        </value>
                    </member>
                    <member>
                        <name>checksum</name>
                        <value>
                            <string>$checksum</string>
                        </value>
                    </member>
                </struct>
            </value>
        </param>
    </params>
</methodCall>";

            return $xml;
    }
}
