<?php


namespace App\Helper;


use App\Jobs\SendSmsJob;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AccessHelper
{

    public  static  function checkIfHasPermission($permId){

        $user  = \App\User::with('roles')->where('id','=',Auth::user()->id)->first();

        $found  =  'false';
        foreach ($user['roles'] as $perm){
            foreach ($perm['permissions'] as $permission){
                if ($permission->id ==$permId){

                    $found = 'true';

                }

            }
        }

        return $found;
    }


    public  static  function  sendOtp(){
        $user =  User::query()
            ->select('token','token_verified','phone_number')
            ->where(['id'=>Auth::user()->id])->first();

        $randomToken  =  random_int(100000,999999);
        $success= DB::table('users')->where(['id'=>Auth::user()->id])->update(['token_verified'=>0,'token'=>Hash::make($randomToken)]);

        if ($success){
            $message  =  'Your login token is '.$randomToken;
            SendSmsJob::dispatch($message,$user->phone_number);
            Session::flash('alert-info','successful sent');
        }else{
            Session::flash('alert-danger','Error,try again');
        }
        return redirect('auth/otp');
    }
}
