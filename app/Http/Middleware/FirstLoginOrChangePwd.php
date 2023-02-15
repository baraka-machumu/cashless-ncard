<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FirstLoginOrChangePwd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user()->is_first_login==1 ||Auth::user()->password_reset==1){
            return redirect('auth/change-password');
        }
        return $next($request);
    }
}
