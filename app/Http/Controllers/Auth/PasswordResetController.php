<?php

namespace App\Http\Controllers\Auth;

use App\AgentPos;
use App\Consumer;
use App\Http\Controllers\Controller;
use App\MerchantAgent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{

    public function  passwordReset(Request $request){

        Log::channel('user-auth-log')->error('password reset request  '.json_encode($request->all()));

        $rules = array(
            'phone_number' => 'required',
            'user_type'=>'required',
            'password'=>'required',

        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }

        try {
            $phoneNo = $request->get('phone_number');
            $userType = $request->get('user_type');
            $password = $request->get('password');

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

            if ($userAuth->otp_verified!=1){

                Log::channel('user-auth-log')->error('OTP not verified for  : '.$userAuth->first_name.' '.$userAuth->last_name);

                return response()->json(['error' => true, 'message' => 'Invalid request']);

            }

            $userAuth->password  =  Hash::make($password);
            $userAuth->otp=  null;
            $userAuth->otp_verified = 0;
            $userAuth->otp_expire  = null;
            $userAuth->is_new  = 0;
            $success  = $userAuth->save();

            if (!$success){

                Log::channel('user-auth-log')->error('can not update passowrd ');

                return response()->json(['error' => true, 'message' => 'Server error']);

            }
            Log::channel('user-auth-log')->error('Password reset successful for   : '.$userAuth->first_name.' '.$userAuth->last_name);

            return response()->json(['error' => false, 'message' => 'Password successful updated']);
        }

        catch(\Exception $exception){
            Log::channel('user-auth-log')->error(' Serrver Error '.$exception->getMessage());

            return response()->json(['error' => true, 'message' => 'Server error']);

        }

    }

}
