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
use App\Helper\RandomGenerator;
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
        $desc  = 'View customer list ';
        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,null,'CUSTOMER','VIEW'));

        $consumers= DB::table('consumer_wallets')
            ->select('consumer_cards.card_number','consumers.status_id','consumer_wallets.wallet_id','consumers.agent_code','consumers.phone_number','consumers.first_name','consumers.last_name')
            ->join('consumers', 'consumers.id', '=', 'consumer_wallets.consumers_id')
            ->leftJoin('consumer_cards', 'consumer_cards.consumers_wallet_id', '=', 'consumer_wallets.wallet_id')
            ->limit(100)->get();

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
            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,'disable customer account',$wallet_id,'CUSTOMER','DISABLE-ACCOUNT'));
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
            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,'Resetting customer pin',$wallet->consumer_wallet_id,'CUSTOMER','PIN-RESET'));

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
        $password   = RandomGenerator::generatePassword();

        $consumer->password =  Hash::make($password);
        $success  = $consumer->save();
        $consumer  = Consumer::query()->select('phone_number')->where(['id'=>$wallet->consumer_wallet_id])->first();
        $message  = 'Nywila  yako mpya ya kwenye application  ni '.$password.'  Endelea kufurahia huduma zetu za NCARD';

        SendSmsJob::dispatch($message, $phone);

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,'Resetting customer password',$wallet->consumer_wallet_id,'CUSTOMER','PASSWORD-RESET'));
        Session::flash('alert-success','success');

        return redirect()->back();
    }

}
