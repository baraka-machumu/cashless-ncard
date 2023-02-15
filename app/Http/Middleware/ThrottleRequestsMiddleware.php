<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ThrottleRequestsMiddleware
{
    /**
     * The rate limiter instance.
     *
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * Create a new request throttler.
     *
     * @param  \Illuminate\Cache\RateLimiter $limiter
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  int $maxAttempts
     * @param  int $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 2, $decayMinutes = 1)
    {
        $request->request->add(['email'=>Auth::user()->email]);
        $key = $this->resolveRequestSignature($request);
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {

            $retryAfter   = $this->limiter->availableIn($key);
            $data  = ['time'=>$decayMinutes,'after'=>$retryAfter];

            if ($request->getPathInfo()==['/auth/verify-otp']){

                Session::flash('alert-danger','Account is locked, wait after '.$retryAfter.' Second(s)');

                return  redirect('auth/otp');
            }
            return redirect('error-access/429-ex/'.encrypt($data));
        }
        $this->limiter->hit($key, $decayMinutes*60);

        return $next($request);

    }

    public  function resolveRequestSignature($request){
        return $request->fingerprint();
    }
}
