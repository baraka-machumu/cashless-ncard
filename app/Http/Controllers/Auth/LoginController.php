<?php

namespace App\Http\Controllers\Auth;

use App\Helper\AccessControl;
use App\Helper\AccessHelper;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckSessionTimeout;
use App\Jobs\SendSmsJob;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
//    use ThrottlesLogins;


public function username()
{
    return 'email';
}

    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected $maxAttempts = 200;

    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */

    protected $decayMinutes = 60;

    public function __construct()
    {
        $auth_methods = ['logout', 'lock', 'unlock', 'locked', 'hasMultipleSessions', 'logoutOtherSessions', 'logoutCurrentSession'];
        $this->middleware('guest')->except($auth_methods);
        $this->middleware('auth')->only($auth_methods);
    }

    public function showLoginForm()

    {
        return view('auth.login');
    }

    public function  loginWeb(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()){
                Session::flash('alert-danger', 'Failed to login');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ( $this->hasTooManyLoginAttempts($request)){
                $this->fireLockoutEvent($request);
                Session::flash('alert-danger','Too Many Login, Account locked');
                return  back();
            }

            if (Auth::attempt(['email'=> $request->email, 'password'=> $request->password,'status'=>1])){
                $user =  Auth::user();

                if ($user->is_first_login==1){
                    return  redirect('/auth/change-password');
                }
                $randomToken  =  random_int(100000,999999);
                $successUpdate  = DB::table('users')->where(['id'=>Auth::user()->id])
                    ->update(['last_login_date'=>$user->recent_login_date,
                        'recent_login_date'=>date('Y-m-d H:i:s'),'token'=>Hash::make($randomToken),'token_verified'=>0]);
                if ($successUpdate){
                    $messageToken  =  'Your login token is '.$randomToken;
                    SendSmsJob::dispatch($messageToken,$user->phone_number);
                    return redirect('auth/otp');
                }
                Log::info('FAILED-LOGIN',['MESSAGE'=>'Failed to update data ','email'=>$request->email]);
                Session::flash('alert-danger', 'Failed to login');
                return back();
            }

            $this->incrementLoginAttempts($request);

            Session::flash('alert-danger', 'Email or password is incorrect');
            return back();
        }catch (\Throwable $exception){

            Log::error('LOGIN-ERROR',['MESSAGE'=>$exception]);
            Session::flash('alert-danger', 'Email or password is incorrect');
            return back();
        }


    }



    public function logout(Request $request)
    {
        Cache::forget(CheckSessionTimeout::getSessionKey());

        Auth::logout();

        return redirect('/');
    }
    public  function  lock(){
        session(['locked' => true, 'last-url' => url()->previous()]);
        return redirect('locked');
    }
    public  function  locked(){
        if (\session('locked',false)!=true){
            return $this->redirectPath();
        }
        return view('auth.locked')->with('flash', 'Account Locked!');
    }
    public  function  unlock(Request  $request){
        $password = $request->post('password');

        $access  = new AccessControl();

        $access->checkLimit();
        if (Hash::check($password,Auth::user()->getAuthPassword())){
            \session()->forget('locked');
            \session()->forget("last-url");
            return AccessHelper::sendOtp();
            //      return \session("last-url",false)?redirect(\session("last-url")):$this->redirectPath();
        }
        $access->addFailedAttempt();
        Session::flash('alert-danger', 'Username or Password is incorrect');
        return redirect()->back();

    }
    public function hasMultipleSessions()
    {
        return view('auth.multiple_session');
    }
    public  function  logoutOtherSessions(){
        if (Cache::get(CheckSessionTimeout::getSessionKey())){
            Session::getHandler()->destroy(Cache::get(CheckSessionTimeout::getSessionKey()));
            CheckSessionTimeout::setCurrentSessionActive();
        }
        return \session("last-url",false)?redirect(\session("last-url")):$this->redirectPath();
    }
    public  function  logoutCurrentSession(){
        Cache::forget(CheckSessionTimeout::getSessionKey());
        Auth::logout();
        return redirect('/');
    }


}
