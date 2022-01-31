<?php

namespace App\Http\Controllers\Auth;

use App\Consumer;
use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ConsumerAuthController extends Controller
{

    public function changePassword(Request $request){
        $rules = array(
            'old_pass' => 'required',
            'password' => 'required|min:6',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }
        $consumer = Consumer::where('id',$this->user_id())->first();
        if (!$consumer){
            return response()->json(['error' => true, 'message' => 'User does not exist']);
        }
        if (!Hash::check($request->get('old_pass'), $consumer->password)) {
            return response()->json(['error' => true, 'message' => 'Passwords do not match']);
        }
        $consumer->password = Hash::make($request->get('password'));
        $consumer->save();
        return response()->json(['error' => false, 'message' => 'password changed']);
    }


    public function passwordReset(Request $request){

        Log::channel('user-auth-log')->error('password reset request  '.json_encode($request->all()));

        $rules = array(
            'password' => 'required|min:6',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }

        try {
            $consumer = Consumer::where('id', $this->user_id())->first();
            if (!$consumer) {
                return response()->json(['error' => true, 'message' => 'User does not exist']);
            }

            $consumer->password = Hash::make($request->get('password'));
            $success = $consumer->save();

            if ($success) {

                Log::channel('user-auth-log')->error('Successful password changed  for '.$consumer->first_name.' '.$consumer->last_name);

                return response()->json(['error' => false, 'message' => 'password changed']);

            }

        }

        catch(\Exception $exception) {
            Log::channel('user-auth-log')->error('Server Error ' .$exception->getMessage());
            return response()->json(['error' => true, 'message' => 'Server Error']);

        }
    }

}
