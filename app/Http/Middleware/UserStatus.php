<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserStatus
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
        $user  =  Auth::user();
        if ($user->status!=1 || $user->is_approved=0 ){

            Session::flash('alert-danger','You are account is not active');
            Auth::logout();
            return redirect('/');

        }
        return $next($request);
    }
}
