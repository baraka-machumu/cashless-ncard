<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class XssSanitization
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

        $input = $request->all();

        $is_ajax  = false;
        if ($request->ajax()){


            array_walk_recursive($input, function(&$input) {
                $input = strip_tags($input);

                if (strpos(strtolower($input), 'cmd') !== false) {
                    return response()->json(['message'=>'Unsupported request','status'=>500]);
                }

                if (strpos(strtolower($input), 'exec') !== false) {
                    return response()->json(['message'=>'Unsupported request','status'=>500]);
                }

                if(filter_var($input, FILTER_VALIDATE_URL)){
                    return response()->json(['message'=>'Unsupported request','status'=>500]);
                }

            });
        }
        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);

            if (strpos(strtolower($input), 'cmd') !== false) {
                Session::flash('danger','unsupported request');
                return back();            }

            if (strpos(strtolower($input), 'exec') !== false) {
                Session::flash('danger','unsupported request');

                return back();            }

            if(filter_var($input, FILTER_VALIDATE_URL)){
                Session::flash('danger','unsupported request');

                return back();
            }


        });
        $request->merge($input);
        return $next($request);
    }
}
