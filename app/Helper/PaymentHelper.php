<?php


namespace App\Helper;


use App\Monitor;
use App\TempoTx;
use App\TxPaymentReference;
use App\TxPayments;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentHelper
{

    public  static  function  getTicket($category,$qnt){

        $TicketSpecifications = [];

        $cat =null;
       $ticket =  0;

////        return $dataFromPos[0]['id'];
//        for ($i=0;$i<sizeof($dataFromPos); $i++){
//
//            if ($dataFromPos[$i]['id'] ==1){
//
//                $cat  =  'a';
//                $ticket =   $ticket+$dataFromPos[$i]['quantity'];
//            }
//            else if ($dataFromPos[$i]['id'] ==2){
//
//                $cat  =  'c';
//                $ticket  =  $ticket+$dataFromPos[$i]['quantity'];
//
//            }
//
//            array_push();
//
//        }

        array_push($TicketSpecifications,['CategoryCode'=>$category,'Qty'=>$qnt]);
//        array_push($TicketSpecifications,['CategoryCode'=>'c','Qty'=>100]);
//
//            if ($ticket==0){
//                DB::table('bill_quantities')->where(['id'=>$billId])->update(['process_ticket_status'=>2]); // means quantity was found 0
//
//                return false;
//            }
        $reference_bulk  =  DB::table('references')->select('reference')->where(['status'=>0])->first();

        $data  = ['PayRef'=>$reference_bulk->reference,'TicketSpecifications'=>$TicketSpecifications];

//            return  $data;
        $client  =  new Client();

        try {

            $result  =  $client->request('post','http://10.60.82.13:8095/tickets/v1/tantrade',
                [
                    'json'=>$data
                ]
            );
            Log::info('Payment successful ');
            Log::channel('tx-payment')->info('tx-response from api '.$result->getBody());

            $jsonData  =  json_decode($result->getBody());

//            Log::channel('tx-payment')->info($jsonData);


            if ($jsonData->resultcode=='01'){

                return  false;
            }

            DB::table('references')->where(['reference'=>$reference_bulk->reference])->update(['status'=>1]);

//          return  sizeof(json_decode($jsonData->result,true));
            foreach (json_decode($jsonData->result,true) as $row){

                $tx  =  new TxPaymentReference();

                $tx->status =  $jsonData->resultcode;
//                $tx->payload  =  $jsonData->result;
                $tx->TicketRef =  $row['TicketRef'];
                $tx->TicketNo =  $row['TicketNo'];
                $tx->BatchRef =  $row['BatchRef'];
                $tx->CategoryCode =  $row['CategoryCode'];
                $tx->Price =  $row['Price'];
                $tx->QRSource =  $row['QRSource'];
                $tx->TicketDate  =  $row['TicketDate'];
//                $tx->ncard_reference  = $reference_bulk->reference;
                $tx->ncard_batch_no =  substr($reference_bulk->reference,4);
                $tx->merchant  =  '12312389';

                $tx->save();
            }

            return  $result;

        } catch (\Exception $exception){
            Log::info('Exception On Payment:: '.$exception->getMessage());


        } catch (GuzzleException $e) {
            Log::info('Exception On Payment:: '.$e);

        }

    }

    public static function  printTicket(Request $request){

        $reference_bulk =  $request->get('reference');

        $tempoTx  =  TempoTx::where(['sha_reference'=>$reference_bulk])->first();

        if(!$tempoTx){
            Log::channel('tx-payment')->error(' reference number '.$reference_bulk);
            return response()->json(['error' => true, 'message' => 'Invalid ticket']);

        } else {
            if ($tempoTx->sha_reference!=$reference_bulk){

                return response()->json(['error' => true, 'message' => 'Bad payment format request']);

            }
        }

        if ($tempoTx->status==0){
            return response()->json(['error' => true, 'message' => 'Please pay for ticket first']);

        }
      TempoTx::where(['sha_reference'=>$reference_bulk])->delete();

        return response()->json([
            'error' => false,
            'ref' => $tempoTx->reference,
            'consumer' =>$tempoTx->consumer_fullname

        ]);






    }

}
