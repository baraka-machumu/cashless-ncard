<?php

namespace App\Http\Controllers\Auth;

use App\Consumer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


//    protected $redirectTo  =  'dashboard';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {

        return view('auth.login');

    }

    public function  WebLogin(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if ($validator->fails()){


            return redirect()->back()->withErrors($validator)->withInput();

        }

        else {

            if (Auth::attempt(['email'=> $request->email, 'password'=> $request->password])){

                $user =  Auth::user();

                    return redirect('dashboard');
            }

            else {


                Session::flash('alert-danger', 'Email or password is incorrect');

                return back();

            }
        }


    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

}
