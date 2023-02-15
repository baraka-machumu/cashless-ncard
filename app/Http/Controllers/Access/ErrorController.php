<?php

namespace App\Http\Controllers\Access;


use App\Http\Controllers\Controller;

class ErrorController extends Controller
{


    public  function  errorLogin(){

        return view('error.login_access');

    }


    public  function  accessDenied(){

        return view('error.access_denied');

    }

    public  function  access429($data){

        $data  = decrypt($data);

        $time  = $data['time'];
        return view('errors.429',compact('time'));

    }

    public static function  UnknowResource($modal,$modalId,$id)
    {

        $captureWalletIdException = $modal::where($modalId, $id)->first();

        if (!$captureWalletIdException) {

            return false;

        }  else {

            return  true;
        }
    }
}
