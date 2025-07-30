<?php

namespace App\Http\Middleware;

use Closure;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Illuminate\Http\Request;

class CachePolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

      return $next($request);
        $response = $next($request);
      //  return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
            //->header('Pragma','no-cache');
    }
}
