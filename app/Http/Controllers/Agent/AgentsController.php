<?php

namespace App\Http\Controllers\Agent;

use App\Agent;
use App\AgentDeposit;
use App\Bank;
use App\BankBranch;
use App\Card;
use App\Consumer;
use App\ConsumerCard;
use App\ConsumerWallet;
use App\AgentPos;
use App\AgentWallet;
use App\District;
use App\FeeDisbursmentAccount;
use App\Gender;
use App\Helper\DataEncryption;
use App\Helper\RandomGenerator;
use App\Helper\SmsHelper;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mail\MailController;
use App\NcardDisbursementAccount;
use App\Pos;

use App\PosAdminAgent;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AgentsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','manage-agent']);
    }
    public  function  topup(Request $request){

        
   if (!Gate::allows('agent-topup')) {

       return  redirect('error-access');


   }
        Log::channel('tx-agent-deposit')->error('Successful top up : '.json_encode($request));

        $agent_code =  $request->agent_code;
        $amount =  $request->amount ;

        $aggregator_wallet  =  $request->aggregator_code;

        $channel_reference  = RandomGenerator::referenceNumber($agent_code);

        $timestamp  =  Carbon::now('Africa/Nairobi')->format('Y-m-d h:i:s');

        $timestamp  = date('Y-m-d\TH:i:s'.'\Z');

//        $ncard_agent_code = $request->agent_code_ncard;


//        $ncardResponse  =  TpesaNcardFund::saveRecord($amount,$channel_reference,$agent_code,$timestamp,$aggregator_wallet,null,$ncard_agent_code);
//
//        if ($ncardResponse['code']!=TpesaNcardFund::SUCCESS){
//
//            Session::flash('alert-danger',' '.$ncardResponse['message']);
//
//            return redirect('/agents/'.$ncard_agent_code);
//
//        }

        try{

            DB::beginTransaction();

            $agent  = AgentWallet::where(['agents_code'=>$agent_code])->first();


            if (!$agent){

                Session::flash('alert-danger','agent does not exist');

                return back();

            }


            $previousBalance =  $agent->amount;

            $currentBalance = $previousBalance+$amount;

            $agentDeposit  =  new AgentDeposit();

            $reference  =  RandomGenerator::referenceNumber($agent_code);

            $agentDeposit->agent_wallet_id =  $agent_code;
            $agentDeposit->amount =  $amount;
            $agentDeposit->tx_channel_reference =  $channel_reference;
            $agentDeposit->previous_balance=  $previousBalance;
            $agentDeposit->current_balance  =  $currentBalance;
            $agentDeposit->reference  = $reference;
            $agentDeposit->created_by  = Auth::user()->id;
            $agentDeposit->source_wallet_number  =  '008008';

            $agentDeposit->save();

            $agent->amount  =  $currentBalance;
            $agent->previous_balance =  $previousBalance;
            $agent->save();

            Log::channel('tx-agent-deposit')->error('Successful top up : '.$agent_code);

            $desc  = "Topup agent from browser.";

             DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGENT','SAVE'));

            DB::commit();

            Session::flash('alert-success','successful credited');

            return redirect('/agents/'.$agent_code);


        }

        catch (\Exception $exception){

            DB::rollBack();
            Log::channel('tx-agent-deposit')->error('Server error topnup agent : '.json_encode($exception));

            Session::flash('alert-danger','could not credit agent '.$exception->getMessage());

            return redirect('/agents/'.$agent_code);

//            return response(['resultcode'=>'01','message'=>'could not credit agent '.$exception->getMessage()]);


        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {


        Log::channel('tx-agent-deposit')->info('Wireless connected');

        $desc  = "View all agents activity";

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,"ALL",'AGENT','VIEW'));


        $agents =  DB::table('agents')
            ->select('ap.imei_no','agents.first_name','agents.last_name','agents.location','agents.email',
                'agents.agent_code','agents.status_id','status.name as sname','agents.phone_number')
            ->leftJoin('agent_pos as ap','ap.agent_code','=','agents.agent_code')

            ->join('status','status.id','agents.status_id')->get();



        $regions  =  DashboardController::getRegions();

        $genders  = Gender::all()->toArray();

        $banks  =  Bank::all()->toArray();

        $branches  =  BankBranch::all()->toArray();


        return view('agents.index',compact('agents','regions','genders','banks','branches'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {

        $desc  = "Access view for creating  agent activity";

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,"ALL",'AGENT','CREATING'));

        $regions  =  DashboardController::getRegions();

//        $top_source  = DB::table('top_up_sources')->get();

        $top_source  =  array();

        $genders  = Gender::all()->toArray();

        return view('agents.create',compact('regions','genders','top_source'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'location' => 'required',
                'district_id' => 'required',
                'phone_number' => 'required',
                'agent_code'=> 'required',
                'pin'=>'required',
                // 'top_up_source'=>'required'

            ]);

        if ($validator->fails()){

            Session::flash('alert-danger','All Field(s) Are Required '.$validator->errors());
            return redirect('agents/create')->withInput();

        }

        $district_id  =  $request->get('district_id');
        $first_name  =  $request->get('first_name');
        $middle_name  =  $request->get('middle_name');
        $last_name  =  $request->get('last_name');
        $gender  =  $request->get('gender');
        $dob =  $request->get('dob');
        $location =  $request->get('location');
        $email  =  $request->get('email');
        $phone_number  =  $request->get('phone_number');
        $pin  =  $request->get('pin');
        $top_up_source  = $request->top_up_source;

        $code = $request->get('agent_code');

        $checkPhone =  Agent::query()->where(['phone_number'=>$phone_number])->first();

        $checkCode =  Agent::query()->where(['agent_code'=>$code])->first();

        if ($checkCode){

            Session::flash('alert-danger', 'Agent Code exist');

            return back();
        }
        if ($checkPhone){

            Session::flash('alert-danger', 'Phone Number exist');

            return back();
        }

//        DB::beginTransaction();
//
//        try {
        $agent = new Agent();
        $agent->first_name = $first_name;
        $agent->middle_name = $middle_name;
        $agent->last_name = $last_name;
        $agent->gender_id = $gender;
        $agent->location = $location;
        $agent->email = $email;
        $agent->phone_number = $phone_number;
        $agent->district_id = $district_id;

        $agent->agent_code = $code;
        $agent->created_by  = Auth::user()->id;


        $success = $agent->save();

        $wallet = new AgentWallet();

        $wallet->agents_code = $code;
        $wallet->amount = 0;
        $wallet->pin = Hash::make($pin);
        $wallet->top_up_source  =  $top_up_source;
        $wallet_success = $wallet->save();

        if ($success & $wallet_success) {

            Session::flash('alert-success', $first_name . ' ' . $last_name . ' Agent wallet Successful created');

            $posAdmin =  new PosAdminAgent();

            $pin  =   DataEncryption::agentPinEncryption($code);

            $posAdmin->agent_code = $code;
//            $posAdmin->pin  =Hash::make($code);
            $posAdmin->pin  =$pin;

            $success =  $posAdmin->save();

            if ($success){

                Session::flash('alert-success', $first_name . ' ' . $last_name . ' Agent wallet Successful created');

            }

            else {

                Session::flash('alert-danger', 'Agent Wallet Failed To be Created');


            }

            return redirect('agents/'.$code);

        } else {

            Session::flash('alert-danger', 'Agent Wallet Failed To be Created');

        }

        $desc  = "save agent to database";

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$code,'AGENT','SAVE'));

        return redirect()->route('show',[$code]);
    }

    public  function  storeAdditionalAgentPos(Request $request){

        $validator  =  Validator::make($request->all(),
            [

                'imei_no'=>'required',
                'location'=>'required'
            ]);


        if ($validator->fails()){

            Session::flash('alert-warning', 'Fill All The Field');

            return redirect()->route('agents.show', ['agent_code' =>$request->agent_code]);
        }

        $imei_no  =   $request->get('imei_no');
        $location  =  $request->get('location');
        $agent_code  =  $request->get('agent_code');


        $checkPosExist =  AgentPos::where('imei_no',$imei_no)->first();

        $email =  Agent::where('agent_code',$agent_code)->first();

        $email =  $email->email;

//        if ($checkPosExist){
//
//            Session::flash('alert-success',' Pos Already Exists');
//
//            return redirect()->route('agents.show',$agent_code);
//
//        }


        for ($i=0; $i<sizeof($imei_no); $i++) {

            $agentPos = new AgentPos();

            $password  =  HelperController::generatePasswod();

            $agentPos->imei_no = $imei_no[$i];

            $agentPos->location = $location[$i];
            $agentPos->agent_code =  $agent_code;

            $agentPos->api_token = Str::random(60);
            $agentPos->password = Hash::make($agent_code);
            $agentPos->created_by  = Auth::user()->id;

            $success = $agentPos->save();

        }


        if ($success){

            DB::table('pos')
                ->where('imei_no',$imei_no)
                ->update(['status_id'=>1]);

            $desc  = "save agent pos to database";

            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGENT','SAVE'));

           // MailController::sendMail($email,$password,$imei_no[0]);

            Session::flash('alert-success',' Pos  successful added');

        }

        else {

            Session::flash('alert-danger', 'Failed to add pos, try again');

        }

        return redirect()->route('agents.show',$agent_code);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($agent_code)
    {


        try {

            $agent_pos  =  DB::table('agent_pos')
                ->where(['agent_code'=>$agent_code])
                ->select('agent_pos.imei_no','status.name','agent_pos.location','agent_pos.status_id')
                ->join('status','status.id','agent_pos.status_id')
                ->get();

            $balance  =  AgentWallet::find($agent_code);

            $balance = $balance['amount'];

            $pos  =  Pos::where('status_id',0)->get();

            $banks  =  Bank::all()->toArray();
            $branches  =  BankBranch::all()->toArray();

            $agent_wallet  =  DB::select('call ViewAgentWalletDetailsByAgentCodeSP(?)',array($agent_code))[0];

            $account  =  NcardDisbursementAccount::query()->where(['type'=>'CUSTOMER'])->first();

//            dd($agent_wallet);

            $agent = DB::table('agents')
                ->select('agents.email','agents.phone_number','agents.first_name','agents.last_name',
                    'agents.middle_name','agents.dob','agents.agent_code','agents.location','districts.name as dname','regions.name as rname','genders.name as gname')
                ->join('districts', 'districts.id', '=', 'agents.district_id')
                ->join('regions', 'districts.region_id', '=', 'regions.id')
                ->join('genders', 'genders.id', '=', 'agents.gender_id')

                ->where('agents.agent_code', $agent_code)->first();

            $desc  = "view only one agent details";

            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGENT','VIEW'));

            return view('agents.show_agent',compact('account','agent_wallet','agent_code','pos','agent_pos','agent','balance','banks','branches'));

        } catch (\Throwable $exception){

            Log::error($exception->getMessage());
            Log::error($exception);

            Session::flash('alert-danger','Some Info is Missing, Contact Admin '.$exception->getMessage());
            return  back();

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agent_code)
    {

        $agent =  Agent::where('agent_code',$agent_code)->first();

        $regions  =  DashboardController::getRegions();

        $districts  =  District::all();
        $genders  = Gender::all()->toArray();
        $region_id  = District::where('id',$agent->district_id)->first()->region_id;

        return view('agents.edit',compact('districts','agent','genders','regions','region_id'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agent_code)
    {



        $validator = Validator::make($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'location' => 'required',
                'district_id' => 'required',
                'phone_number' => 'required',

            ]);

        if ($validator->fails()){

            Session::flash('alert-danger','All Fields Are Required');
            return redirect()->route('agents.edit',$agent_code);

        }

        $district_id  =  $request->get('district_id');
        $first_name  =  $request->get('first_name');
        $middle_name  =  $request->get('middle_name');
        $last_name  =  $request->get('last_name');
        $gender_id  =  $request->get('gender');
        $dob =  $request->get('dob');
        $location =  $request->get('location');
        $email  =  $request->get('email');
        $phone_number  =  $request->get('phone_number');


        $success = DB::table('agents')
            ->where('agent_code',$agent_code)
            ->update([
                'first_name'=>$first_name,
                'middle_name'=>$middle_name,
                'last_name'=>$last_name,
                'gender_id'=>$gender_id,
                'location'=>$location,
                'email'=>$email,
                'phone_number'=>$phone_number,
                'district_id'=>$district_id
            ]);

        if ($success){

            Session::flash('alert-success',' Agent  Successful updated');

        }

        else {

            Session::flash('alert-danger', 'Failed to update agent');

        }

        $desc  = "Update agent details";

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGENT','UPDATE'));

        return redirect('agents');

    }

    public  function disableAccount(Request $request){

        $agent_code  =  $request->agent_code;

        $success  = DB::table('agents')
            ->where('agent_code', $agent_code)
            ->update(['status_id' => 0]);

        if ($success){

            $desc  = "disable Account";

            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGENT','DISABLE'));

            Session::flash('alert-success',' Agent successful disabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to disable the agent');

        }

        return redirect('agents');


    }
    public  function enableAccount(Request $request){

        $agent_code  =  $request->agent_code;

        $success  = DB::table('agents')
            ->where('agent_code', $agent_code)
            ->update(['status_id' => 1]);
        if ($success){
            $desc  = "enable Account";

            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGENT','ENABLE'));

            Session::flash('alert-success',' Agent successful enabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to enabled the agent');

        }

        return redirect('agents');

    }

    public function  posCreate($agent_code){

        $pos  =  Pos::where('status_id',0)->get();


        $agent = Agent::where('agent_code',$agent_code)->first();
        $fullname  =  $agent->first_name.' '.$agent->last_name;
        return view('agents.pos_create',compact('pos','agent_code','fullname'));

    }

    public  function storeAgentPosCredentials(Request $request,$code){

        $location  =  $request->get('location');
        $imei_no  =  $request->get('imei_no');

        $password  =    HelperController::generatePasswod();
        $api_token  =  HelperController::apiToken();

        $agent_pos  = new AgentPos();

        $agent_pos->location =  $location;
        $agent_pos->password =  Hash::make($password);
        $agent_pos->agent_code =  $code;
        $agent_pos->api_token =  $api_token;
        $agent_pos->imei_no =  $imei_no;
        $agent_pos->created_by  = Auth::user()->id;

        $success =  $agent_pos->save();

        DB::table('pos')
            ->where('imei_no', $imei_no)
            ->update(['status_id' => 1]);

        if ($success){

            $desc  = "Store agent pos to database";

            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$code,'AGENT','SAVE'));

            Session::flash('alert-success',' Agent Pos  Successful created');

        }

        else {

            Session::flash('alert-danger', 'Failed to create agent pos');

        }

        return redirect('agents');

    }
    public function  login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'agent_code' => 'required',
            'imei_no' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()){
            return response()->json(["error"=>true,"message"=>$validator->errors()->all()]);
        }

        $credentials = $request->only('agent_code', 'password');
        $agent = AgentPos::where('agent_code', $request->input('agent_code'))->first();
        if ($agent){
            if ($agent->imei_no != $request->get('imei_no')){
                return response()->json(['error' => true, 'message' => 'You don\'t have permission to device']);
            }
            if (Auth::guard('agent')->attempt($credentials)){
                $agent->generateToken();
                return response()->json([
                    'error' => false,
                    'data'=>$agent,
                    'agent'=>Agent::where('agent_code', $request->get('agent_code'))->first(),
                    'wallet'=> AgentWallet::where('agents_code', $request->get('agent_code'))->first()
                ]);
            }
            return response()->json(["error"=>true,"message"=>"code or password is incorrect"]);
        }
        return response()->json(["error"=>true,"message"=>"Agent does not exist"]);

    }

    public  function  addPosForm($agent_code){


        return view('agents.add_pos_form');

    }

    public  function  getAllPos(){

        $pos  =  Pos::where('status_id',0)->get();

        return response()->json($pos);
    }

    public  function disablePos(Request $request){

        $imei_no  =  $request->get('imei_no');

        $success  = DB::table('pos')
            ->where('imei_no', $imei_no)
            ->update(['status_id' => 0]);

        DB::table('agent_pos')
            ->where('imei_no', $imei_no)
            ->update(['status_id' => 0]);

        if ($success){

            Session::flash('alert-success',' Pos successful disabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to disable the pos');

        }

        return redirect()->back();


    }
    public  function enablePos(Request $request){

        $imei_no  =  $request->get('imei_no');

        $success  = DB::table('pos')
            ->where('imei_no', $imei_no)
            ->update(['status_id' => 1]);

        DB::table('agent_pos')
            ->where('imei_no', $imei_no)
            ->update(['status_id' => 1]);

        if ($success){

            Session::flash('alert-success',' Pos successful enabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to enabled the pos');

        }

        return redirect()->back();

    }

    public  function  getAgentDataJson($agent_code){

        $agent = DB::table('agents')
            ->select('agents.email','agents.phone_number','agents.first_name','agents.last_name',
                'agents.middle_name','agents.dob','agents.gender_id','agents.district_id','districts.region_id','agents.agent_code','agents.location','districts.name as dname','regions.name as rname','genders.name as gname')
            ->join('districts', 'districts.id', '=', 'agents.district_id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->join('genders', 'genders.id', '=', 'agents.gender_id')

            ->where('agents.agent_code', $agent_code)->first();


        return response()->json(['error'=>'false','data'=>$agent]);
    }

    public  function  pinReset(Request $request){

        $agentCode  = $request->agent_code;

        $agent  =  AgentWallet::where(['agents_code'=>$agentCode])->first();

        $pin  =  $request->pin;

        $agent->pin =  Hash::make($pin);
        $success  = $agent->save();
        $desc  = "Reset pin for agent";

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agentCode,'AGENT','RESET-PIN'));

        if ($success){

            Session::flash('alert-success','success');
        }
        else {
            Session::flash('alert-danger','fail');

        }

        return redirect('agents/'.$agentCode);


    }

    public  function  passwordReset(Request $request){

        $agentCode  = $request->agent_code;

        $agent  =  AgentPos::where(['agent_code'=>$agentCode])->first();

        if (!$agent){
            Session::flash('alert-danger','agent does not have pos assigned');

            return redirect('agents/'.$agentCode);

        }
        $password  =  $request->password;

        $agent->password =  Hash::make($password);
        $success  = $agent->save();
        $desc  = "Reset password for agent";

        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agentCode,'AGENT','RESET-password'));

        if ($success){

            Session::flash('alert-success','success');
        }
        else {
            Session::flash('alert-danger','fail');

        }

        return redirect('agents/'.$agentCode);


    }

    public  function  getByPhoneNumber(Request $request){

        $phoneNumber  =  $request->phone_number;

        $agent  =  Agent::query()->where(['phone_number'=>$phoneNumber])->first();


        if ($agent){
            Session::flash('alert-success','Found');

            return redirect('agents/'.$agent->agent_code);

        }
        Session::flash('alert-success','Not Found');

        return redirect('agents');
    }

}
