<?php

namespace App\Http\Controllers;

use App\BankBranch;
use App\ConsumerDeposit;
use App\District;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public  function  adminDashboard(){

        $data =  $this->getTotalForDashboard();

        $deposits  =  ConsumerDeposit::query()->sum('amount');

        return view('dashboard',compact('data'));
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

        $data  =[];

        $merchants  =  DB::table('merchants')->count();
        $users  =  DB::table('users')->count();
        $roles  =  DB::table('roles')->count();
        $agents  =  DB::table('agents')->count();
        $permissions  =  DB::table('permissions')->count();
        $service  =  DB::table('services')->count();
        $consumers  =  DB::table('consumers')->count();
        $active_cards  =  DB::table('consumer_cards')->count();
        $permissions  =  DB::table('permissions')->count();
        $permissions  =  DB::table('permissions')->count();


        $data['merchants'] =  $merchants;
        $data['users'] =  $users;
        $data['roles'] =  $roles;
        $data['permissions'] =  $permissions;
        $data['consumers'] =  $consumers;
        $data['agents'] =  $agents;
        $data['services'] =  $service;
        $data['users'] =  $users;
        $data['users'] =  $users;
        $data['active_cards'] =  $active_cards;

        return $data;

    }





}
