<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class XFrameHeadersMiddleware
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
        return $next($request);
        /**
         * This middleware was created to prevent OWASP warnings, like:
         *
         * The X-Frame-Options header is not set in the HTTP response, meaning the page can potentially be loaded into
         * an attacker-controlled frame. This could lead to clickjacking, where an attacker adds an invisible layer on
         * top of the legitimate page to trick users into clicking on a malicious link or taking a harmful action.
         *
         * The X-Frame-Options allows three values: DENY, SAMEORIGIN and ALLOW-FROM. It is recommended to use DENY,
         * which prevents all domains from framing the page or SAMEORIGIN, which allows framing only by the same site.
         * DENY and SAMEORGIN are supported by all browsers. Using ALLOW-FROM is not recommended because not all browsers support it.
         *
         * For more information, access: https://cheatsheetseries.owasp.org/cheatsheets/Clickjacking_Defense_Cheat_Sheet.html
         *
         */

        $host  =  Config::get('api.HOST')??'malipo.kimtandao.co.tz';

        $allowed_hosts = array($host,'malipo.kimtandao.co.tz','127.0.0.1:8000');

        if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_hosts)){

            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
            exit;
        }
        $untrusted_headers  = ['X-Forwarded-For','X-Host','X-Remote-IP','X-Remote-Addr','X-Client-IP',
            'X-Forwarded-Host'];

        if ($request->header('X-Forwarded-For')){

            abort(400);
        }
        if ($request->header('X-Forwarded-Host')){
            abort(400);

        }
        if ($request->header('X-Host')){
            abort(400);

        }
        if ($request->header('X-Remote-IP')){
            abort(400);

        }
        if ($request->header('X-Remote-Addr')){
            abort(400);

        }
        if ($request->header('X-Client-IP')){
            abort(400);
        }

        if ($request->header('X-Forwarded-Host')){
            abort(400);
        }

        if ($request->header('Host')!=$host){

            abort(401);
        }

        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        return $response;
    }
}
