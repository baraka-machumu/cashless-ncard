<?php

namespace App\Http\Controllers\Encryption;

use App\Helper\DataEncryption;
use App\Helper\RandomGenerator;
use App\Merchant;
use App\TempoTx;
use App\TxSoldTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EncryptionController extends Controller
{


    public  function  dataEncryptionDump(Request $request){

        try {
            $data_reference =$request->get('reference');
            $json_data  =  $request->get('products');
            $tin  =  $request->get('tin');
            $service_id  =  $request->get('service_id');

            if(empty($data_reference)){

                $tempoTx  =  new TempoTx();

                $reference_bulk  =  DB::table('references')->select('reference')->where(['status'=>0])->first();

                $encrypted = DataEncryption::encryptData($reference_bulk->reference);
//                $QrFromSource  =  DB::table('tx_payment_reference')->select('QRSource')->where(['is_taken'=>0])->first();

                $tempoTx->reference  =  $reference_bulk->reference;
                $tempoTx->json_data  =  $json_data;
                $tempoTx->sha_reference =$encrypted;
                $tempoTx->tin  = $tin;
                $tempoTx->service_id  =  $service_id;
                $tempoTx->save();

                DB::table('references')->where(['reference'=>$reference_bulk->reference])->update(['status'=>1]);
                return response()->json(['error' => false, 'qr' => $encrypted]);

            }


            else {

                $tempoTx  =   TempoTx::where(['sha_reference'=>$data_reference])->first();

                $tempoTx->json_data  = $json_data;
                $tempoTx->save();
                return response()->json(['error' => false, 'qr' => $tempoTx->sha_reference]);

            }


        } catch (\Exception $exception){

            Log::channel('tx-qr')->error(' Qr error    '.$exception);
            return response()->json(['error' => true, 'message' => 'Server Error ']);

        }

    }

    public  function  dataEncryption(Request $request){

        $encrypted = DataEncryption::encryptData(RandomGenerator::qr());

        $data_reference =$request->get('reference');
        $json_data  =  $request->get('products');

        Log::channel('tx-payment')->info($json_data);
        $tin  =  $request->get('tin');
        $service_id  =  $request->get('service_id');

        $merchant =  Merchant::query()->select('managed_by')->where(['tin'=>$tin])->first();

        $qr  = null;

        if ($merchant->managed_by=='NCARD'){

            $qr=  'NC20'.$encrypted;

        }

        else if ($merchant->managed_by=='EXTERNAL'){

            $my_data  =  json_decode($json_data);
            Log::channel('tx-payment')->info($json_data);

            $cat =  $my_data[0]->category;
            Log::channel('tx-payment')->info($cat);

            $QrFromSource  =  DB::table('tx_payments_reference')->select('QRSource','BatchRef','CategoryCode')
                ->whereDate('created_at', Carbon::today())
                ->where(['is_taken'=>0,'CategoryCode'=>$cat,'status'=>0])->first();

            if (!$QrFromSource){
                return response()->json(['error' => true, 'message' => 'No Ticket for today ']);

            }
            $qr =  $QrFromSource->QRSource;

        }
        DB::beginTransaction();
        try {

            if(empty($data_reference)){

                $tempoTx  =  new TempoTx();

                $tempoTx->json_data  =  $json_data;
                $tempoTx->sha_reference =$encrypted;
                $tempoTx->qr = $qr;
                $tempoTx->tin  = $tin;
                $tempoTx->service_id  =  $service_id;
                $tempoTx->save();

                if ($merchant->managed_by=='EXTERNAL') {

                    DB::table('tx_payments_reference')->where(['QRSource' => $qr])->update(['status' =>1,'updated_at'=>Carbon::now('Africa/Nairobi')]);  //  1 means is held

                }

                DB::commit();
                return response()->json(['error' => false, 'qr' => $qr]);

            }
            else {

                $tempoTx  =   TempoTx::where(['qr'=>$data_reference])->first();

                $tempoTx->json_data  = $json_data;
                $tempoTx->save();
                DB::commit();

                return response()->json(['error' => false, 'qr' => $tempoTx->qr]);

            }

        } catch (\Exception $exception){

            DB::rollBack();

            Log::channel('tx-qr')->error(' Qr error    '.$exception);
            return response()->json(['error' => true, 'message' => 'Server Error ']);

        }

    }




}
