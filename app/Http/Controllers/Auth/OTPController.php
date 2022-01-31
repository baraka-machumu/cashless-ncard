<?php

namespace App\Http\Controllers\Auth;

use App\AgentPos;
use App\Consumer;
use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use App\MerchantAgent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OTPController extends Controller
{

    public function  forgotPassword(Request $request){

        $rules = array(
            'phone_number' => 'required',
            'user_type'=>'required',

        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }

        try {
            $phoneNo = $request->get('phone_number');
            $userType = $request->get('user_type');

            switch ($userType) {
                case 'C':
                    $userAuth = Consumer::where('phone_number', $phoneNo)->first();

                    break;
                case 'A':
                    $userAuth = AgentPos::where('agent_code', $request->input('agent_code'));

                    break;
                case 'M':
                    $userAuth = MerchantAgent::where('phone_number', $phoneNo)->first();

                    break;

                default:

                    return response()->json(['error' => true, 'message' => 'Invalid request']);

            }

            if (!$userAuth) {
                return response()->json(['error' => true, 'message' => 'User does not exist']);
            }

            $otp = random_int(10000,99999);

            $userAuth->otp = $otp;
            $userAuth->otp_expire = Carbon::now('Africa/Nairobi')->addRealSeconds(60);
            $userAuth->save();

            $message = 'Token yako ya N CARD ni ' . $otp;

            SendSmsJob::dispatch($message, $phoneNo);

            return response()->json(['error' => false, 'message' => 'message sent']);
        }
        catch(\Exception $exception){
            return response()->json(['error' => true, 'message' => 'Server error']);

        }
    }


    public function  verifyOTP(Request $request){

        Log::channel('user-auth-log')->error('password reset request  '.json_encode($request->all()));

        $rules = array(
            'phone_number' => 'required',
            'user_type'=>'required',
            'otp'=>'required'

        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }

        try {
            $phoneNo = $request->get('phone_number');
            $userType = $request->get('user_type');
            $otp = $request->get('otp');
            $agentCode  =   $request->input('agent_code');

            switch ($userType) {
                case 'C':
                    $userAuth = Consumer::where(['phone_number'=>$phoneNo,'otp'=>$otp])->first();

                    break;
                case 'A':
                    $userAuth = AgentPos::where(['agent_code'=>$agentCode,'otp'=>$otp]);

                    break;
                case 'M':
                    $userAuth = MerchantAgent::where(['phone_number'=>$phoneNo,'otp'=>$otp])->first();

                    break;

                default:

                    return response()->json(['error' => true, 'message' => 'Invalid request or wrong OTP']);

            }

            if (!$userAuth) {

                return response()->json(['error' => true, 'message' => 'Invalid OTP or request']);
            }

            $now  = Carbon::now('Africa/Nairobi');

            if ($now>$userAuth->otp_expire){

                Log::channel('user-auth-log')->error('TIME : '.$userAuth->otp_expire.'::=> Invalid request , time expire for '.$userAuth->first_name.'  '.$userAuth->last_name);

                return response()->json(['error' => true, 'message' => 'Invalid request']);

            }

            $userAuth->otp_verified =  1;
            $success  = $userAuth->save();

            if (!$success){

                Log::channel('user-auth-log')->error('can not update otp ');

                return response()->json(['error' => true, 'message' => 'Server error']);

            }

            return response()->json(['error' => false, 'message' => 'Account successful verified']);
        }

        catch(\Exception $exception){
            return response()->json(['error' => true, 'message' => 'Server error']);

        }
    }

}
