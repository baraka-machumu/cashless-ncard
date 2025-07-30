<?php

namespace App\Http\Controllers;

use App\BankBranch;
use App\ConsumerDeposit;
use App\District;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public  function  adminDashboard(){
        $desc  = 'View dashboard';
        DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,null,'DASHBOARD','VIEW'));

        return view('dashboard');
    }

    public  static  function getAccessToUserInfo($id){

        $consumer= DB::table('users')
            ->select('users.email','users.phone_number','consumers.first_name','consumers.last_name')
            ->join('consumers', 'users.id', '=', 'consumers.user_id')
            ->where('users.role_id', $id);

        $agents = DB::table('users')
            ->select('users.email','users.phone_number','agents.first_name','agents.last_name')
            ->join('agents', 'users.id', '=', 'agents.user_id')
            ->where('users.role_id', $id);

        $userstoreroles = DB::table('users')
            ->select('users.email','users.phone_number','merchant_users.first_name','merchant_users.last_name')
            ->join('merchant_users', 'users.id', '=', 'merchant_users.user_id')
            ->where('users.role_id', $id)
            ->unionAll($consumer)
            ->unionAll($agents)->get();

        return $userstoreroles;
    }


    // function to list all regions
    public  static function  getRegions(){

        $regions  =  Region::all()->toArray();

        return $regions;

    }

    // function to list all districts

    public   function  getDistricts(Request $request){

        $id  =  $request->get('id');
        $districts  =  District::where('region_id',$id)
            ->select('id','name')
            ->get();

        return $districts;

    }

    //  function that return all branch per bank
    public   function  getBranches(Request $request){


        $id  =  $request->get('id');


        $branches  =  BankBranch::where('bank_id',$id)
            ->select('id','name')
            ->get();

        return $branches;

    }




    // functions that return total data for particular table in dashboard
    public function  getTotalForDashboard(){
        ini_set('memory_limit','2040M');
        set_time_limit(0);
        $data  =[];

        $merchants  =  DB::table('merchants')->count('tin');
        $pos  =  DB::table('pos')->count('imei_no');
        $agents  =  DB::table('agents')->count('agent_code');
        $service  =  DB::table('services')->count();
        $consumers  =  DB::table('consumers');
        $cards  =  DB::table('consumer_cards')->select('card_uid');
        $topup_channel=DB::table('gateways')->count('id');
        $deposits=0;//DB::table('consumer_deposits')->sum('amount')??0.00;
        $payments=0;//DB::table('consumer_payments')->sum('amount');

        $data['merchants'] =  $merchants;
        $data['consumers'] =  count($consumers->where(['status_id'=>1])->get());
        $data['in_consumers'] =  count($consumers->where('status_id','!=',1)->get());

        $data['agents'] =  $agents;
        $data['services'] =  $service;
        $data['pos'] =  $pos;
        $data['active_cards'] =  count($cards->where(['status_id'=>'1'])->get());
        $data['in_cards'] =  count($cards->where('status_id','!=',1)->get());

        $data['topup_channel'] =  $topup_channel;
        $data['deposits'] =  $deposits;
        $data['payments'] =  $payments;

        return $data;

    }





}
