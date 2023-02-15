<?php

namespace App\Http\Controllers\Auth;

use App\Helper\AccessControl;
use App\Helper\AccessHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    public function __construct()
    {
        $this->middleware('custom-th')->only('verify');
    }
    public function otpForm()
    {
        if (Auth::user()->token_verified==1){
            return  redirect('dashboard');
        }
        return view('auth.otp');
    }

    public  function  resentToken(){
        return AccessHelper::sendOtp();
    }

    public  function  verify(Request  $request){
        /**
         * CHECK INPUT VALIDATIONS
         */
        $validator  = Validator::make($request->all(),
        [
            'otp'=>'required|digits_between:6,6'
        ]);
        if ($validator->fails()){
            Session::flash('alert-danger','Invalid input');
            return back();
        }
        /**
         * PROCESS REQUEST
         */
        $token  = $request->otp;
        $access  = new AccessControl();
         $access->checkLimit();
        if (Hash::check($token,Auth::user()->token)){

            $success  = User::query()->where(['id'=>Auth::user()->id])->update(['token_verified'=>1]);
            if ($success){
                return  redirect('dashboard');
            }
            Session::flash('alert-danger','Failed to authenticate');
            return  back();
        }
        $access->addFailedAttempt();
        Session::flash('alert-danger','Invalid OTP');
        return  back();
    }

}
