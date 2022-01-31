<?php

namespace App\Http\Controllers\Sms;

use App\Consumer;
use App\Helper\SmsHelper;

use App\Http\Controllers\helper\HelperController;
use App\Jobs\SendSmsJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SmsController extends Controller
{

    public  function  sendSmsApi(Request $request){

        $message  =  $request->message;
        $phoneNumber  =  $request->phone_number;

        $result  =   SmsHelper::sendSms($message,$phoneNumber);

        return $result;

    }

    public  static function  sendSms($message, $phoneNumber){

        $result  =   SmsHelper::sendSms($message,$phoneNumber);

        return $result;

    }

    public  static function  resendOTP(Request $request,$wallet_id){

        $phoneNumber = $request->phone_number;
        $consumer = Consumer::where('phone_number',$phoneNumber)->first();

        if (!$consumer){

            Session::flash('alert-success',' User not exist');

            return back();
        }

        $password  =  HelperController::generatePasswod();

        $consumer->password  = Hash::make($password);
        $consumer->otp_expire =  Carbon::now('Africa/Nairobi');

        $success =  $consumer->save();

        $message =  'Nywila yako mpya ya N CARD ni '.$password;

        SendSmsJob::dispatch($message,array($phoneNumber));

        return  redirect('consumers/'.$wallet_id);

    }
}
