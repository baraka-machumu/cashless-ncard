<?php


namespace App\Helper;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccessControl
{

    use  AuthenticatesUsers;
    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected $maxAttempts = 3;

    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */

    protected $decayMinutes = 1;

    public  function  checkLimit(){


        if ( $this->hasTooManyLoginAttempts(self::addRequest())){
            $this->fireLockoutEvent(self::addRequest());
            Session::flash('alert-danger','Too Many Attempt, Account locked');
            return  back();
        }
    }

    public  function  addFailedAttempt(){

        $this->incrementLoginAttempts(self::addRequest());
    }

    public  function  addRequest(){
        $request  =  new Request();
        $request->request->add(['email'=>Auth::user()->email]);
        return $request;
    }

}
