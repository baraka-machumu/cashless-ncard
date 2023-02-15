<?php

namespace App\Http\Controllers\Auth;

use App\AgentPos;
use App\Consumer;
use App\Http\Controllers\Controller;
use App\MerchantAgent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{

    public function  changePassword()
    {
        $user = Auth::user();
        return view('auth.change_password',compact('user'));

    }
    public  function  saveNewPassword(Request  $request){

        $validate  = Validator::make($request->all(),[
           'old_password'=>'required',
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/'],
        ]);

        if ($validate->fails()){
            $error   =  collect($validate->getMessageBag());
            Session::flash('alert-danger', ''.$error->first()[0]);
            return  back();
        }

        $old_password = $request->old_password;
        $user  = User::query()->where(['id'=>Auth::user()->id])->first();

        if (!Hash::check($old_password,$user->password)){
            Session::flash('alert-danger', 'Invalid credentials');
            return  back();
        }

        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if ($password!=$confirm_password){
            Session::flash('alert-danger', 'Password does not match');
            return  back();
        }


        $password  =  $request->password;
        $user->password = Hash::make($password);
        $user->is_first_login  =0;
        $user->password_reset  =0;

        $success  =  $user->save();
        if ($success){
            Session::flash('alert-success', 'Successful changed.');
            return  redirect('/');
        }
        else{
            Session::flash('alert-danger', 'Failed to change password , try again');
            return  back();
        }

    }

}
