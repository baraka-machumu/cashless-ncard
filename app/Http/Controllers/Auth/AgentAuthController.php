<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AgentAuthController extends Controller
{



    public  function  changePassword(Request $request){

        $oldPassword  = $request->old_password;
        $password  = $request->password;

        try {
            $agentCode = JWTAuth::parseToken()->authenticate()->agent_code;

            $authPassword = JWTAuth::parseToken()->authenticate()->password;

            if (Hash::make($oldPassword) == $authPassword) {

                $success = DB::table('agents')->where(['agent_code' => $agentCode])->update(['password' => $password]);

                if ($success) {

                    return response()->json(['error' => false, 'message' => 'Successful updated']);

                }
                return response()->json(['error' => true, 'message' => 'Server Error']);

            }
            return response()->json(['error' => true, 'message' => 'Incorrect Password']);

        } catch (\Exception $exception){

            return response()->json(['error' => true, 'message' => 'Server Error 500']);

        }

    }
}
