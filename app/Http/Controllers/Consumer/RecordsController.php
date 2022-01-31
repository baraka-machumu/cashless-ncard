<?php

namespace App\Http\Controllers\Consumer;

use App\ConsumerPayment;
use App\ConsumerPlateNumber;
use App\ConsumerWallet;
use App\Http\Controllers\Controller;
use App\MerchantCollectionAccount;
use App\PassRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // return response()->json(['errors'=>false,'message'=>"Success"]);

        $record = new PassRecord();

        $data =  json_decode(file_get_contents("php://input"));


//        return response()->json(['errors'=>true,'message'=>$data]);

        $record->vehicle_no = $data->vehicleNo;
        $record->gate_no = $data->parkingNo;
        $record->ipcamera = $data->iPCam;
        $record->confidence = $data->confidence;
        $record->pass_date_time = $data->passDateTime;
        $record->picture_name = $data->pictureName;
        $record->picture_path = $data->picturePath;
        $record->remarks = $data->remark;

        $success =  $record->save();

//        return response()->json(['errors'=>true,'message'=>$success]);

        $tin  =  12345678;

        $reference =  uniqid();
        $plate_no_exist = DB::table('plate_numbers')->where('plate_no',$data->vehicleNo)->first();

        if($plate_no_exist){

            $vehicle_type = $plate_no_exist->vehicle_type;

            $charge = DB::table('vehicle_charges')->where('vehicle_type',$vehicle_type)->first();


            $amount =  $charge->charge;

//            $consumer_wallet_id  =DB::table('vehicle_charges')->where('vehicle_type',$vehicle_type)->first();


            $consumer_plate_no =   ConsumerPlateNumber::where('plate_no',$data->vehicleNo)->first();

            if (!$consumer_plate_no){
                return response()->json(['error'=>true,'message'=>'Hakuna namba ya gari']);
            }
            $consumer_wallet_id  = $consumer_plate_no->consumer_wallet_id;

            $consumer_wallet =  ConsumerWallet::where('wallet_id', $consumer_wallet_id)->first();

            $balane  =  $consumer_wallet->amount;


            if ($balane<$amount){

                return response()->json(['error'=>true,'message'=>'Hauna Salio']);

            }
            $consumer_payment =  new ConsumerPayment();

            $consumer_payment->consumer_wallet_id =  $consumer_wallet_id;
            $consumer_payment->amount  = $amount;
            $consumer_payment->status =  1;
            $consumer_payment->recipient_type =  3;
            $consumer_payment->reference  =$reference;
            $consumer_payment->recipient_id =  $tin;

            $consumer_payment->save();





            $balane= $balane-$amount;

            $consumer_wallet->amount =  $balane;

            $consumer_wallet->save();

            $merchant_collection  =  new MerchantCollectionAccount();

            $merchant_collection->amount  =  $amount;
            $merchant_collection->consumer_wallet_id  =  $consumer_wallet_id;
            $merchant_collection->reference  =  $reference;

            $merchant_collection->merchants_id  =  $tin;
            $merchant_collection->status =  1;

            $success =   $merchant_collection->save();

            if ($success){

                return response()->json(['error'=>false,'message'=>'Umefanikiwa kulipa']);

            }


        }

        else {

            return response()->json(['error'=>true,'message'=>'Namba Haipo']);

        }





    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
