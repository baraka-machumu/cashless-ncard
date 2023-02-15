<?php

namespace App\Http\Controllers\Consumer;

use App\AgentWallet;
use App\Consumer;
use App\ConsumerCard;
use App\ConsumerDeposit;
use App\ConsumerPayment;
use App\ConsumerPlateNumber;
use App\ConsumerWallet;
use App\Deposit;
use App\FeeCollectionAccount;
use App\Helper\SmsHelper;
use App\Jobs\SendSmsJob;
use App\Merchant;
use App\MerchantCollectionAccount;
use App\PlateNumber;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ConsumerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('manage-consumer')) {

            return redirect('error-access');

        }

        $consumers= DB::table('consumer_wallets')
            ->select('consumer_cards.card_number','consumers.status_id','consumer_wallets.wallet_id','consumers.agent_code','consumers.phone_number','consumers.first_name','consumers.last_name')
            ->join('consumers', 'consumers.id', '=', 'consumer_wallets.consumers_id')
            ->leftJoin('consumer_cards', 'consumer_cards.consumers_wallet_id', '=', 'consumer_wallets.wallet_id')
            ->limit(1000)->get();

        return view('consumers.index',compact('consumers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('manage-consumer')) {

            return redirect('error-access');

        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:consumers',
            'password' => 'required|min:8',
            'fname' => 'required',
            'lname' => 'required',
            'gender' => 'required',
            'phone_number' => 'required|unique:consumers',
            'pin' => 'required|min:4',
        ]);

        if ($validator->fails()){
            return response()->json(['error'=>true, 'message' => $validator->errors()->all()]);
        }

        $consumer  =  new Consumer();

        $consumer->email =  $request->get('email');
        $consumer->first_name =  $request->get('fname');
        $consumer->last_name =  $request->get('lname');
        $consumer->gender_id =  $request->get('gender');
        $consumer->dob =  $request->get('dob');
        $consumer->status_id =  1;
//        $consumer->location =  $request->get('location');
        $consumer->phone_number  =  $request->get('phone_number');
        $consumer->password  =  Hash::make($request->get('password'));
        $consumer->api_token =  Str::random(60);

        $user_success = $consumer->save();

        if ($user_success) {
//TODO generate wallet id with defined length
            $wallet = new ConsumerWallet();
            $wallet->wallet_id = crc32(uniqid());
            $wallet->amount = 0;
            $wallet->consumers_id = $consumer->id;
            $wallet->consumers_status_id = $consumer->status_id;
            $wallet->pin = Hash::make($request->get('pin'));
            $wallet->save();
            return response()->json(['error'=>false,'data'=>$consumer, 'wallet' => $wallet]);
        }

        return response()->json(['error'=>true,'message'=>'Registration failed']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($wallet_id)
    {
        if (!Gate::allows('manage-consumer')) {

            return redirect('error-access');

        }

        $consumer= DB::table('consumers')
            ->where('consumer_wallets.wallet_id',$wallet_id)
            ->select('consumers.id as id','consumer_cards.card_number','consumer_wallets.wallet_id','consumers.agent_code','consumers.phone_number','consumers.first_name',
                'consumers.last_name','consumers.email','consumers.location','genders.name as gname','consumers.dob','consumer_wallets.amount','consumer_wallets.consumers_status_id as status',
                'consumers.created_at','status.name as sname','consumers.status_id as status_id')
            ->join('genders','genders.id','=','consumers.gender_id')
            ->join('consumer_wallets', 'consumers.id', '=', 'consumer_wallets.consumers_id')
            ->join('status','status.id','=','consumers.status_id')
            ->leftJoin('consumer_cards', 'consumer_cards.consumers_wallet_id', '=', 'consumer_wallets.wallet_id')->first();

        $deposits  =  DB::table('consumer_deposits')->sum('amount');
        $payments =  DB::table('consumer_payments')->sum('amount');

        return view('consumers.show',compact('consumer','deposits','payments'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        if (!Gate::allows('manage-consumer')) {

            return redirect('error-access');

        }
        $first_name  =  $request->first_name;
        $last_name  =  $request->last_name;
        $phone_number  =  $request->phone_number;

        $consumer  = Consumer::where(['id'=>$id])->first();

        $consumer->first_name  =  $first_name;
        $consumer->last_name  =  $last_name;
        $consumer->phone_number  =  $phone_number;
        $success  = $consumer->save();

        if ($success){
            Session::flash('alert-success','Successful updated');
        } else{
            Session::flash('alert-danger','failed to update');

        }

        return back();
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

    public function addPlateNumber(Request $request){
//        TODO make all these queries under transaction
        $validator = Validator::make($request->all(), [
            'plate_no' => 'required|unique:consumer_plate_numbers',
            'wallet_id' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['error'=>true, 'message' => $validator->errors()->all()]);
        }

        $plateNo = new ConsumerPlateNumber();
        $plateNo->plate_no = $request->get('plate_no');
        $plateNo->consumer_wallet_id = $request->get('wallet_id');
        $plateNo->save();

        $plateRecord = new PlateNumber();
        $plateRecord->plate_no = $request->get('plate_no');;//take plate number from the parameret
        $plateRecord->vehicle_type = 'suv';
        $plateRecord->save();
        return response()->json(['error'=>false, 'data' => $plateNo]);
    }

    public  function  logout()
    {
        if (Auth::check()){
            $user  =  auth()->user();
            $user->api_token =  null;
            $user->save();
            return response()->json(['error' => false,'message'=>'Logout successful']);
        }
        return response()->json(['error' => true, 'message' => 'Unable to logout user']);

    }

    public function  login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(["errors"=>true,"message"=>$validator->errors()->all()]);

        }

        if (empty($request->get('email')) && empty($request->get('phone_number'))){
            return response()->json(['error'=>true,'message'=>'Email or phone required']);
        }

        if (!empty($request->get('email'))){
            $credentials = $request->only('email', 'password');
            $consumer = Consumer::where('email', 'like', $request->input('email'))->first();
        }else{
            $credentials = $request->only('phone_number', 'password');
            $consumer = Consumer::where('phone_number', 'like', $request->input('phone_number'))->first();
        }
        if ($consumer){
            if (Auth::guard('consumer')->attempt($credentials)){
                $consumer->generateToken();
                return response()->json([
                    'error' => false,
                    'data'=>$consumer,
                    'wallet' => ConsumerWallet::where('consumers_id', $consumer->id)->first()
                ]);
            }
            return response()->json(['error'=>true,'message'=>'username or password is incorrect']);
        }
        return response()->json(['error'=>true,'message'=>'user does not exist']);
    }

    public function makePayment($merchant_id, Request $request){
//        TODO make all these queries under transaction
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['error'=>true, 'message' => $validator->errors()->all()]);
        }

        $walletId = $request->get('wallet_id');
        $card_no = $request->get('card_number');
        $amount = $request->get('amount');

        if (empty($walletId) && empty($card_no)){
            return response()->json(['error' => true, 'message' => 'Either wallet number or card number is needed']);
        }

        $merchant = Merchant::where('id', $merchant_id)->first();
        if (!$merchant){
            return response()->json(['error' => true, 'message' => 'Merchant does not exist']);
        }
        if ($merchant->status_id != 1){
            return response()->json(['error' => true, 'message' => 'Merchant is not available for service']);
        }

        $reference = uniqid();
//        reduce consumer wallet
        $c_wallet = null;
        if (!empty($walletId)){
            $c_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();
            if ($c_wallet->amount < $amount){
                return response()->json(['error' => true, 'message' => 'No enough balance']);
            }
            DB::table('consumer_wallets')->where('wallet_id', $walletId)->update(['amount' => $c_wallet->amount-$amount]);
        }else{
            $c_card = ConsumerCard::where('card_number', $card_no)->first();
            $walletId = $c_card->consumers_wallet_id;

            $c_wallet = ConsumerWallet::where('wallet_id', $walletId)->first();
            if ($c_wallet->amount < $amount){
                return response()->json(['error' => true, 'message' => 'No enough balance']);
            }
            DB::table('consumer_wallets')->where('wallet_id', $walletId)->update(['amount' => $c_wallet->amount-$amount]);
        }

//        pay merchant account
        $m_c_account = new MerchantCollectionAccount();
        $m_c_account->amount = $amount;
        $m_c_account->status = 1;
        $m_c_account->reference = $reference;
        $m_c_account->save();

        $c_deposit = new ConsumerPayment();
        $c_deposit->consumer_wallet_id = $walletId;
        $c_deposit->amount = $amount;
        $c_deposit->status = 1;
        $c_deposit->reference = $reference;
        $c_deposit->recepient_type = 1;
        $c_deposit->recepient_id = $merchant_id;
        $c_deposit->save();


//        record it in collection account
        $collect = new FeeCollectionAccount();
        $collect->fee_charges = 100;
        $collect->consumer_payment_reference = $reference;
        $collect->save();

        return response()->json(['error' => false, 'wallet' => $c_wallet]);
    }


    public  function  getPlateByConsumerId($consumer_wallet_id){

//        $plate_no =  ConsumerPlateNumber::where('consumer_wallet_id',$consumer_wallet_id)->get();

        $plate_no =  DB::table('consumer_plate_numbers')->where('consumer_wallet_id',$consumer_wallet_id)->get();


        if ($plate_no){
            return response()->json(['error'=>false,'data'=>$plate_no]);

        }
        return response()->json(['error'=>true,'plate_no'=>$plate_no]);

    }


    public  function  getAllConsumerDeposits($consumer_wallet_id){

        $deposits = ConsumerDeposit::with('consumerWallet.consumer')->where('consumer_wallet_id', $consumer_wallet_id)->get();


        $consumerInfo =  DB::table('consumer_wallets')
            ->select('consumer_wallets.amount','consumer_wallets.wallet_id','consumers.first_name','consumers.last_name')
            ->join('consumers', 'consumers.id', '=', 'consumer_wallets.consumers_id')
            ->where('consumer_wallets.wallet_id', $consumer_wallet_id)->first();

//        return response()->json($deposits);
        return view('wallets.consumer_deposit',compact('deposits','consumerInfo'));
    }


    public  function disableAccount(Request $request){

        $wallet_id  =  $request->consumer_wallet;
        $status_id  =  $request->get('status_id');

        if ($status_id!=''){

            if ($status_id==0){

                return $this->enableAccount($request);
            }
        }


        $success  = DB::table('consumer_wallets')
            ->where('wallet_id', $wallet_id)
            ->update(['consumers_status_id' => 0]);

        $consumer  =  ConsumerWallet::where('wallet_id',$wallet_id)->first();
        DB::table('consumers')
            ->where('id', $consumer->consumers_id)
            ->update(['status_id' => 0]);

        if ($success){

            Session::flash('alert-success',' Consumer successful disabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to disable the Consumer');

        }

        return redirect()->back();


    }
    public  function enableAccount(Request $request){

        $wallet_id  =  $request->consumer_wallet;

        $success  = DB::table('consumer_wallets')
            ->where('wallet_id', $wallet_id)
            ->update(['consumers_status_id' => 1]);

        $consumer  =  ConsumerWallet::where('wallet_id',$wallet_id)->first();
        DB::table('consumers')
            ->where('id', $consumer->consumers_id)
            ->update(['status_id' => 1]);


        if ($success){

            Session::flash('alert-success',' Consumer successful enabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to enable the Consumer');

        }

        return redirect()->back();

    }

    public  function  pinReset(Request $request){

        $wallet_id  = $request->wallet_id;

        $wallet  =  ConsumerWallet::where(['wallet_id'=>$wallet_id])->first();

        $pin  = random_int(1012,9998);

        $wallet->pin =  Hash::make($pin);
        $success  = $wallet->save();

        $consumer  = Consumer::query()->select('phone_number')->where(['id'=>$wallet->consumers_id])->first();

        $message  = 'Pin yako mpya ya malipo ni '.$pin.'  Endelea kufurahia huduma zetu za NCARD';

        $result  =   SmsHelper::sendSms($message,$consumer->phone_number);

//   return $result;
        if ($success){

            Session::flash('alert-success','success');
        }
        else {
            Session::flash('alert-danger','fail');

        }

        return redirect()->back();


    }

    public  function  passwordReset(Request $request){

        $wallet_id  = $request->wallet_id;

        $wallet  =  ConsumerWallet::where(['wallet_id'=>$wallet_id])->first();

        $consumer  =  Consumer::where(['id'=>$wallet->consumers_id])->first();

        $phone =  $consumer->phone_number;
        $password   =  $request->password;

        $consumer->password =  Hash::make($password);
        $success  = $consumer->save();

        $consumer  = Consumer::query()->select('phone_number')->where(['id'=>$wallet->consumer_wallet_id])->first();

        $message  = 'Nywila  yako mpya ya kwenye application  ni '.$password.'  Endelea kufurahia huduma zetu za NCARD';

        SendSmsJob::dispatch($message, $phone);


        Session::flash('alert-success','success');



        return redirect()->back();


    }

}
