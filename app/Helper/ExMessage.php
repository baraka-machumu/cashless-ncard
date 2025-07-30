<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ExMessage
{

    public  static  function  exp($Throwable){


        Log::error('EXCEPTION',['MESSAGE'=>$Throwable]);

        if (app()->environment()=='local'){

            Session::flash('alert-danger','something went wrong');
        }

        else {

            Session::flash('alert-danger','Failed');
        }

    }
}
