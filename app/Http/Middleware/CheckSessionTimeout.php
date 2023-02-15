<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckSessionTimeout
{
    const  CACHE_SESSION_MULTIPLE_ID  = 'SESSION-ID-';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('locked')==true){
            return  redirect('locked');
        }
        $sessionId =  Cache::get(self::getSessionKey(),null);
        if (!empty($sessionId)){
            if ($sessionId != session()->getId()){
                session(['last-url' => url()->current()]);
                return redirect('multiple-sessions');
            }
        } else{
            self::setCurrentSessionActive();
        }
        return $next($request);
    }

    public  static  function  setCurrentSessionActive(){
        Cache::put(self::getSessionKey(),session()->getId(),Carbon::now()->addMinutes(20));
    }

    public  static  function  getSessionKey(): string
    {
        return self::CACHE_SESSION_MULTIPLE_ID.Auth::user()->id;

    }

}
