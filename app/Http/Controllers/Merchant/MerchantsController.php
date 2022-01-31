<?php

namespace App\Http\Controllers\Merchant;

use App\Bank;
use App\BankBranch;
use App\District;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\Mail\MailController;
use App\Merchant;
use App\MerchantAgent;
use App\MerchantCashIn;
use App\MerchantCashTaken;
use App\MerchantGroup;
use App\MerchantPos;
use App\MerchantService;
use App\MerchantType;
use App\NcardCommsionPolicy;
use App\Pos;
use App\PosAdminMerchant;
use App\Region;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Exception;

class MerchantsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','manage-merchant']);
    }

    public function  index(){

        $regions  =  DashboardController::getRegions();

        $merchants  = Merchant::all()->toArray();

        $banks=  Bank::all();

        $services  =  Service::all();
        $districts  = District::all();

        $merchantTypes  = MerchantType::query()->get();

        $merchantGroups  = MerchantGroup::query()->get();

        $managedby  =  DB::table('managed_by')->select('name')->get();

//        return response()->json($merchantTypes);
        return view('merchants.index',compact('managedby','merchantGroups','merchantTypes','regions','merchants','banks','services','districts'));

    }

    public  function create(){

        $regions  =  DashboardController::getRegions();


        $merchants  = Merchant::all()->toArray();

        $banks=  Bank::all();

        $services  =  Service::all();
        $districts  = District::all();

        $merchantTypes  = MerchantType::query()->get();

        $merchantGroups  = MerchantGroup::query()->get();

        $comm =  DB::table('communication_types')->get();

        $managedby  =  DB::table('managed_by')->select('name')->get();

        return view('merchants.create',compact('comm','managedby','merchantGroups','districts','merchants','merchantTypes','regions','services','banks'));
    }

    public function  edit($merchant_id){

        $merchants  =  Merchant::where('tin',$merchant_id)->first();

        $region_id  = District::find($merchants->district_id);

        $region_id  =  $region_id['region_id'];

        $regions  =  DashboardController::getRegions();
        $banks  =  Bank::all()->toArray();
        $services  =  Service::all()->toArray();
        $districts  =  Service::all()->toArray();

        $bank_id  =  BankBranch::find($merchants['branch_id']);

        $bank_id =  $bank_id['bank_id'];

        $bank_branches  =  BankBranch::all()->toArray();

        return view('merchants.edit',compact('bank_id','region_id','districts','merchants','regions','banks','bank_branches','services'));

    }

    public function  store(Request $request){

//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'telephone'=>'required',
            'region'=>'required',
            'location'=>'required',
            'district'=>'required',
            'email'=>'required',
            'branch'=>'required',
            'account'=>'required',
            'tin'=>'required|unique:merchants',
            'bank'=>'required',
            'merchantType'=>'required',
            'group_code'=>'required',
            'managedby'=>'required'

        ]);

        if ($validator->fails()){


            Session::flash('alert-warning', $validator->getMessageBag());

            return   redirect()->back();

        }


        $district_id  =  $request->get('district');
        $name   =        $request->get('name');
        $tin  =          $request->get('tin');
        $phone_number  = $request->get('telephone');
        $email =         $request->get('email');
        $location  =     $request->get('location');
        $maccount  =     $request->get('account');
        $mregion =       $request->get('region');
        $mbank = $request->get('bank');

        $group_code  =  $request->get('group_code');

        $managedby  =  $request->get('managedby');

        $merchantType  =  $request->merchantType;

        $mbranch  =      $request->get('branch');



//        if (RandomGenerator::isHTML($name)) {
//
//            Session::flash('alert-warning', 'Invalid input');
//
//            return  back();
//
//        }


        $merchantTin  =  Merchant::query()->where(['tin'=>$tin])->first();

        if ($merchantTin){

            Session::flash('alert-warning', 'Merchant tin  exists');

            return back()->withInput();
        }

        // tin
        $tin_file = $request->file('tinno_certificate');

        $tinname = time().'.'.$tin_file->getClientOriginalExtension();
        $tin_file_path = public_path('/tin');
        $tin_file->move($tin_file_path, $tinname);
//        $deposit->slip_path =  $destinationPath;

        // business liscen
        $business = $request->file('business');

        $bname = time().'.'.$business->getClientOriginalExtension();
        $business_destinationPath = public_path('/businessl');
        $business->move($business_destinationPath, $bname);


        //
        // pay_sliip ni image from html form;
        $bank_verify = $request->file('bankverification');

        $bankvname = time().'.'.$bank_verify->getClientOriginalExtension();
        $bank_verify_destinationPath = public_path('/bankv');
        $bank_verify->move($bank_verify_destinationPath, $bankvname);

        $merchant =  new Merchant();

        $merchant->district_id = $district_id;
        $merchant->name = $name;
        $merchant->tin = $tin;
        $merchant->phone_number = $phone_number;
        $merchant->email = $email;
        $merchant->location = $location;
        $merchant->account_number = $maccount;
        $merchant->branch = $mbranch;
        $merchant->bank =  $request->bank;
        $merchant->business_license =  $business_destinationPath;
        $merchant->tin_certificate  =  $tin_file_path;
        $merchant->bank_verification  = $bank_verify_destinationPath;
        $merchant->merchant_type  =  $merchantType;
        $merchant->group_code  =  $group_code;
        $merchant->managed_by = $managedby;
        $merchant->add_on_mobile  =  $request->addMobile;
        $merchant->created_by  = Auth::user()->id;
        $merchant->communication_type  = $request->comm_type;
        $merchant->ip  = $request->ip;
        $merchant->port  = $request->port;

        $success = $merchant->save();

        $cashInAccount  = new MerchantCashIn();

        $cashInAccount->merchant_tin =  $tin;
        $cashInAccount->amount =  0;
        $cashInAccount->save();

        $cashInAccount  = new MerchantCashTaken();

        $cashInAccount->merchant_tin =  $tin;
        $cashInAccount->amount =  0;

        $cashInAccount->save();

        if ($success){

            Session::flash('alert-success', $name.' Merchant Successful created');
            $posAdmin =  new PosAdminMerchant();

            $posAdmin->tin = $tin;
            $posAdmin->pin  =Hash::make(HelperController::generatePin());

            $success =  $posAdmin->save();

            if ($success){

                Session::flash('alert-success', $name.' Merchant Successful created');

            }

            else {

                Session::flash('alert-success', $name.' Failed to create merchant, try again');

            }
            return  redirect('merchants/'.$tin);

        } else {

            Session::flash('alert-danger', $name.' Failed to create merchant, try again');

        }

        return redirect('merchants');

    }

    public function show($tin)
    {

        $merchant_pos  =  DB::table('merchant_pos')
            ->where('tin',$tin)
            ->select('merchant_pos.imei_no','status.name','merchant_pos.location')
            ->join('status','status.id','merchant_pos.status_id')
            ->get();

        $merchantServices  =  DB::table('merchant_services')
            ->where('tin',$tin)
            ->select('merchant_services.id','merchant_services.service_id','services.name')
            ->join('services','services.id','merchant_services.service_id')
            ->get();

//       return response($merchantServices);
        $stations  =  DB::table('udart_stations')->get();

        $pos  =  Pos::query()->where(['status_id'=>0])->get();

//        return response()->json($pos);
        $regions  =  DashboardController::getRegions();

        $services  =  Service::all();

        $districts  =  Service::all()->toArray();

        $merchant = DB::table('merchants')
            ->select('merchant_types.name as merchant_type','merchants.status_id','merchants.email','merchants.phone_number',
                'merchants.name','merchants.account_number','merchants.tin','merchants.location','districts.name as dname','regions.name as rname')
            ->join('districts', 'districts.id', '=', 'merchants.district_id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->join('merchant_types', 'merchant_types.id', '=', 'merchants.merchant_type')

            ->where('merchants.tin', $tin)->first();

        $commission  =  NcardCommsionPolicy::query()->where(['merchant_tin'=>$tin])->first();



        $URL  = base_url().'/lantana/v1/wbs/tinified-events/'.$tin;

        $events  =  Http::get($URL);

        $events = json_decode($events);


            if ($events->resultcode=='0'){

                $events = $events->result;
            }
            else
            {
                $events =  array();
            }


        return view('merchants.show_merchant',compact('events','tin','commission','merchantServices','services','stations','pos','merchant_pos','merchant','regions','districts'));
    }


    public  function  storePos(Request $request){

        $validator  =  Validator::make($request->all(),
            [
                'imei_no'=>'required',
                'location'=>'required',

            ]);


        if ($validator->fails()){

            Session::flash('alert-warning', 'Fill All The Field');

            return redirect()->route('agents.show', ['agent_code' =>$request->agent_code]);
        }

        $imei_no  =   $request->get('imei_no');
        $location  =  $request->get('location');
        $tin  =  $request->get('tin');


        $checkPosExist =  MerchantPos::where('imei_no',$imei_no)->first();

        if ($checkPosExist){

            Session::flash('alert-warning',' Pos Already Exists');
            return redirect()->route('merchants.show',$tin);

        }

        $email =  Merchant::where('tin',$tin)->first();

        $email =  $email->email;

        DB::beginTransaction();
        try {
            for ($i = 0; $i < sizeof($imei_no); $i++) {

                $merchantPos = new MerchantPos();

                $merchantPos->imei_no = $imei_no[$i];
                $merchantPos->location = $location[$i];
                $merchantPos->tin = $tin;
                $merchantPos->created_by  =  Auth::user()->id;
                $success = $merchantPos->save();

                DB::table('pos')
                    ->where(['imei_no'=>$imei_no[$i]])
                    ->update(['status_id' => 1]);
            }

            DB::commit();
            Session::flash('alert-success',' Pos  successful added');


        } catch (\Exception $exception){
            DB::rollBack();
            Session::flash('alert-danger', 'Failed to add pos, try again '.$exception->getMessage());

        }



        return redirect('merchants/'.$tin);
    }


    public  function  storeMerchantAgentUsers(Request $request)
    {

        $firstName  =  $request->get('first_name');
        $lastName  =  $request->get('last_name');
        $station  =  $request->get('station_code');
        $phone_number  =  $request->get('phone_number');
        $tin  =  $request->get('tin');
        $imei_no =  $request->get('imei_no');

        $password  =  HelperController::generatePasswod();

        $text =  "You have been assined pos ".$imei_no.' with password '.$password;


//        dd(HelperController::sendSms($text,$phone_number));

        if (empty($firstName)){

            Session::flash('alert-success','Failed to save user');

            return back();

        }
        for ($i=0; $i<sizeof($firstName); $i++) {

            $merchantAgent = new MerchantAgent();

            $password  =  HelperController::generatePasswod();
            $apiToken =  HelperController::apiToken();

            $merchantAgent->first_name  =  $firstName[$i];
            $merchantAgent->last_name  =  $lastName[$i];
            $merchantAgent->station_code  =  $station[$i];
            $merchantAgent->phone_number  =  $phone_number[$i];
            $merchantAgent->tin =  $tin;
            $merchantAgent->api_token =  $apiToken;
            // todo LIST replace phone number as password
            $merchantAgent->password =  Hash::make($phone_number[$i]);
            $merchantAgent->imei_no =  $imei_no;
            $merchantAgent->created_by  =  Auth::user()->id;

            $merchantAgent->save();

//            MailController::sendMail($email[$i],$password,$imei_no);

        }

        Session::flash('alert-success','Saved');
        return redirect()->back();

    }



    public  function  editUserMerchant ($tin){

        $merchantAgent =  MerchantAgent::where(['tin'=>$tin])->first();

        return view('merchants.edit_merchant_user',compact('merchantAgent'));

    }

    public  function  updateMerchantAgentUsers(Request $request)
    {

        $firstName  =  $request->get('first_name');
        $lastName  =  $request->get('last_name');
//        $email  =  $request->get('email');
        $phone_number  =  $request->get('phone_number');

        if (empty($firstName)){

            Session::flash('alert-success','Failed to save user');

            return back();

        }

            $merchantAgent = new MerchantAgent();

            $merchantAgent->first_name  =  $firstName;
            $merchantAgent->last_name  =  $lastName;
//            $merchantAgent->email  =  $email[$i];
            $merchantAgent->phone_number  =  $phone_number;
            $merchantAgent->password  = Hash::make(12345678);
            $merchantAgent->save();

        Session::flash('alert-success','Saved');
        return redirect()->back();

    }

    public  function  stoteMerchantService(Request $request)
    {

        $service  =  $request->get('service');

        $tin =  $request->get('tin');

        for ($i=0; $i<sizeof($service); $i++) {

            $merchantService  =  new MerchantService();

            $merchantService->service_id  =  $service[$i];
            $merchantService->tin  =  $tin;
            $merchantService->created_by  =  Auth::user()->id;


            $merchantService->save();

        }
        Session::flash('alert-success', ' Merchant Service Successful created');

        return redirect()->back();


    }

    public  function  getMerchantData($tin){


        $merchant  =  DB::table('merchants as m')
            ->select('merchant_type','m.name','m.tin','m.phone_number','m.account_number','m.location','m.email',
                'm.district_id','m.status_id','m.branch_id','m.service_id','bank_branches.bank_id','districts.region_id')
            ->join('bank_branches','bank_branches.bank_id','=','m.branch_id')
            ->join('districts','districts.id','=','m.district_id')
            ->where('m.tin',$tin)

            ->first();

        return response(['error'=>false,'data'=>$merchant]);

    }

    public  function  update(Request $request,$tin){

        $district_id  =  $request->get('district');
        $name   =        $request->get('name');
//        $tin  =          $request->get('tin');
        $phone_number  = $request->get('telephone');
        $email =         $request->get('email');
        $location  =     $request->get('location');
        $maccount  =     $request->get('account');

        $mbank =         $request->get('bank');
        $mbranch  =      $request->get('branch');
        $service  =      $request->get('service');

        $merchantType  =  $request->merchantType;


        $merchant =  Merchant::find($tin);

        $merchant->district_id = $district_id;
        $merchant->name = $name;
        $merchant->tin = $tin;
        $merchant->phone_number = $phone_number;
        $merchant->email = $email;
        $merchant->location = $location;
        $merchant->account_number = $maccount;
        $merchant->branch_id = $mbranch;
        $merchant->merchant_type  =  $merchantType;
//        $merchant->service_id = $service;

//        $merchant->business_license =  $business_destinationPath;
//        $merchant->tin_certificate  =  $tin_file_path;
//        $merchant->bank_verification  = $bank_verify_destinationPath;
        $success = $merchant->save();

        if ($success){

            Session::flash('alert-success', $name.' Merchant Successful updated');

        } else {

            Session::flash('alert-danger', $name.' Merchant update failed');

        }

        return redirect()->route('merchants.show',['tin'=>$tin]);

    }

    public  function disableAccount(Request $request){

        $tin =  $request->tin;

        $success  = DB::table('merchants')
            ->where('tin', $tin)
            ->update(['status_id' => 0]);

        if ($success){

            Session::flash('alert-success',' Merchant successful disabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to disable the Merchant');

        }

        return redirect('merchants/'.$tin);

    }
    public  function enableAccount(Request $request){

        $tin  =  $request->tin;

        $success  = DB::table('merchants')
            ->where('tin', $tin)
            ->update(['status_id' => 1]);

        if ($success){

            Session::flash('alert-success',' Merchant successful enabled');

        }

        else {

            Session::flash('alert-danger', 'Failed to enable the Merchant');

        }

        return redirect('merchants/'.$tin);

    }

    public  function  getMerchantAgentUsers($imei_no){

        $merchantAgents  = MerchantAgent::where('imei_no',$imei_no)->get();

        return view('merchants.show_merchant_agents',compact('merchantAgents'));

    }




}
